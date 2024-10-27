<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>



    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<?php
require("element/nav.php")
?>

<div class="container main-con">
  <div class="row">
    <div class="col-md-6"></div>
    <div class="col-md-6 p-5">
      <form action="" class="bg-white rounded p-5 signup-form" autocomplete="off">
        <h1 class="text-center">Sign Up</h1>

       <div class="mb-3">
       <label class="form-label" for="username">Username</label>
       <input required="required" type="text" id="username" class="form-control">
       </div>

       <div class="mb-3 email_container">
       <label class="form-label" for="username">Email</label>
       <input required="required" type="email" id="email" class="form-control">
       <i class="fa-solid fa-circle-notch fa-spin email_loader d-none"></i>
       </div>

        <div class="mb-3 pass_container">
        <label class="form-label" for="username">Password</label>
        <input required="required" type="password" id="password" class="form-control">
        <i class="fa-regular fa-eye pass_icon"></i>
        </div>

        <div class="mb-4 d-flex justify-content-between">
          <div class="form-text">Click Generate to Improve Sequrity</div>
          <button id="gen-pass" class="btn btn-sm btn-danger ">Generate</button>
        </div>

        <div class="text-center"> <button disabled="disabled"  class="btn btn-primary w-50 register_btn">Register NOW</button></div>
        <div class="msg"></div>
      </form>

      <form action="" class="bg-white rounded p-5 act-form d-none" autocomplete="off">
        <h1 class="text-center">Actiavate Your Account</h1>

       <div class="mb-3">
       <label class="form-label" for="activation_code">activation code</label>
       <input required="required" type="text" id="activation_code" class="form-control">
       </div>

       <div class="text-center">
        <button class="btn btn-primary w-50 activation_btn">Activate Now</button>
       </div>

       <div class="activation_msg"></div>
      </form>
      
    </div>
  </div>
</div>

<script>
  $(function(){
    $("#gen-pass").on("click",function(e){
      e.preventDefault()
      $("#password").attr("type","text")
        $(".pass_icon").css({color:"black"})
$.ajax({
  type: "POST",
  url: "generate_password.php",
  beforeSend:function(){
    $(".pass_icon").removeClass("fa-regular fa-eye")
    $(".pass_icon").addClass("fa-solid fa-circle-notch fa-spin")
  },
  success: function (response) {
    $(".pass_icon").removeClass("fa-solid fa-circle-notch fa-spin")
    $(".pass_icon").addClass("fa-regular fa-eye")
    $("#password").val(response.trim())
  }
});
    })

    
//Eye button functionality
    $(".pass_icon").on("click",function(){
      if ($("#password").attr("type")=="password") {
        $("#password").attr("type","text")
        $(".pass_icon").css({color:"black"})
      }else{
        $("#password").attr("type","password")
        $(".pass_icon").css({color:"#ccc"})
      }
    })



    //email loader
    $("#email").on('input',function(){
      $(".email_loader").removeClass("d-none");
    })

    //check already registered user
    $("#email").on("change",function(){
      $.ajax({
        type: "POST",
        url: "check_user.php",
        data: {
          email:$(this).val()
        },
       
        success: function (response) {
        
          $(".email_loader").removeClass("fa-solid fa-circle-notch fa-spin")
          if (response.trim()=="usernotmatch") {
            $(".email_loader").removeClass("fa-solid fa-xmark")
            $(".email_loader").addClass("fa-solid fa-check")
            $(".email_loader").css({color:"green"})
            $(".register_btn").removeAttr("disabled")
          }else{
            $(".email_loader").removeClass("fa-solid fa-check")
            $(".email_loader").addClass("fa-solid fa-xmark")
            $(".email_loader").css({color:"red"})
            $(".register_btn").attr("disabled","disabled")
          }
        }
      });
    })

//register functionality
$(".signup-form").submit(function(e){
e.preventDefault()

$.ajax({
  type: "POST",
  url: "register.php",
  data: {
    username:$("#username").val(),
    email:$("#email").val(),
    password:$("#password").val()
  },
  beforeSend:function(){
    $(".register_btn").html("Please Wait...")
    $(".register_btn").attr("disabled","disabled")
  },
  success: function (response) {
    $(".register_btn").html("Register NOW")
    $(".register_btn").removeAttr("disabled")
   if (response.trim() == "Success") {
    let div = document.createElement("DIV")
    div.className = "alert alert-success m-3"
div.innerHTML = "Register Success"
$(".msg").append(div)
setTimeout(() => {
  $(".msg").html("")
  $(".signup-form").addClass("d-none");
  $(".act-form").removeClass("d-none");
}, 3000);
   }else if(response.trim() == "Failed"){
    let div = document.createElement("DIV")
    div.className = "alert alert-warning m-3"
div.innerHTML = "User Already Exists"
$(".msg").append(div)
setTimeout(() => {
  $(".msg").html("")
  $(".signup-form").trigger('reset');
}, 3000);
   }else{
    let div = document.createElement("DIV")
    div.className = "alert alert-danger m-3"
div.innerHTML = "Register Failed"
$(".msg").append(div)
setTimeout(() => {
  $(".msg").html("")
  $(".signup-form").trigger('reset');
}, 3000);
   }
  }
});
})

//Activation Form Functionality
$(".act-form").on("submit",function(e){
  e.preventDefault()
  $.ajax({
    type: "POST",
    url: "check_act_code.php",
    data: {
      email:$("#email").val(),
      act:$("#activation_code").val()
    },
    beforeSend: function(){
      $(".activation_btn").html("Checking Activation Code...")
      $(".activation_btn").attr("disabled","disabled")
    },
    success: function (response) {
      $(".activation_btn").html("Activate Now")
      $(".activation_btn").removeAttr("disabled")

      if (response.trim() == "Your Account Is Active Now") {
    let div = document.createElement("DIV")
    div.className = "alert alert-success m-3"
div.innerHTML = "Account Activated"
$(".activation_msg").append(div)
setTimeout(() => {
  $(".activation_msg").html("")
 window.location = "login.php"
}, 3000);
   }else{
    let div = document.createElement("DIV")
    div.className = "alert alert-danger m-3"
div.innerHTML = "Wrong Activation Code"
$(".activation_msg").append(div)
setTimeout(() => {
  $(".activation_msg").html("")
}, 3000);
   }
     
      
    }
  });
})
  })
</script>
</body>
</html>