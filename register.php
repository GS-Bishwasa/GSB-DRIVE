<?php
require("db.php");
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $pattern = "1234567890";
    $length= strlen($pattern);
    $v_code = [];
    // $pass=  $pattern[rand(0,83)];
    for ($i=0; $i < 4; $i++) { 
        $index = rand(0,$length-1);
        // There’s a small issue with your code: the rand(0, $length) will sometimes pick an index out of bounds because strlen($pattern) returns the number of characters, but the index starts from 0. So, the maximum index should be $length - 1.
        $v_code[] = $pattern[$index];
    }
    $ver_code = implode($v_code);
 $fullname =  $_POST['username'];
 $email =  $_POST['email'];
 $password = md5($_POST['password']);
 $check = "SELECT email FROM users WHERE email = '$email'";
 $response  = $db->query($check);
 if ($response->num_rows != 0) {
    echo "user Match";
 }else{
    $send_atc = mail($email,"Activation Code","Thank You For Choosing Our Product <br> Your Activation Code Is " .$ver_code,"From:okfas7023@gmail.com");
    if ($send_atc == true) {
        $store = "INSERT INTO users(full_name,email,password,activation_code) VALUES('$fullname','$email','$password','$ver_code')";
if($db->query($store)){
    echo"Success";
}else{
    echo"Failed";
}
    }else{
        
        echo "Try Again With Other Email Id";
    }
 }
}else{
    echo"unauthorised request";
}
?>