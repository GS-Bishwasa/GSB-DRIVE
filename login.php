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
      <form action="" class="bg-white rounded p-5 login-form" autocomplete="off">
        <h1 class="text-center">Login</h1>


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

        <div class="text-center"> <button  class="btn btn-primary w-50 login_btn">Login Now</button></div>
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
    
        $(".login-form").on("submit",function(e){
            e.preventDefault()
            $.ajax({
                type: "POST",
                url: "user.php",
                data: {
                    email:$("#email").val(),
                    pass:$("#password").val(),
                },
                beforeSend:function(){
$("#login_btn").attr("disabled","disabled")
$("#login_btn").html("Please Wait...")
},
success: function (response) {
    $("#login_btn").removeAttr("disabled")
                    $("#login_btn").html("Login Now")
                    if (response.trim() == "Success") {
                        window.location = "profile.php"
                    }else if(response.trim() == "pending"){
                        $(".login-form").addClass("d-none")
                        $(".act-form").removeClass("d-none")
                    }else if(response.trim() == "Wrong Password"){
                        let div = document.createElement("DIV")
    div.className = "alert alert-danger m-3"
div.innerHTML = "Wrong Password"
$(".msg").append(div)
setTimeout(() => {
  $(".msg").html("")
}, 3000); 
                    }else if(response.trim() == "usernotmatch"){
                        let div = document.createElement("DIV")
    div.className = "alert alert-warning m-3"
div.innerHTML = "User Not Registered"
$(".msg").append(div)
setTimeout(() => {
  $(".msg").html("")
}, 3000); 
                    }
                }
            });
        })


        // Activtion Code program
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