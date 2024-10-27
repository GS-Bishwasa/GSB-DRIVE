<?php

session_start();
require("db.php");
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $email = $_POST["email"];
    $password =md5( $_POST["pass"]);
    $check = "SELECT email FROM users WHERE email = '$email'";
    $response = $db->query($check);
    if ($response->num_rows != 0) {
        $user_check = "SELECT * FROM users WHERE email = '$email' AND password = '$password' ";
        $res = $db->query($user_check);
        if ($res->num_rows != 0) {
            $check_status = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND status = 'active'";
            $status = $db->query($check_status);
            if ($status->num_rows != 0) {
echo"Success";
$_SESSION['user'] = $email;
}else{
                echo"pending";

            }
        }else{
            echo"Wrong Password";
        }
    }else{
        echo "usernotmatch";
    }
}else{
    echo"unauthorised request";
}
?>