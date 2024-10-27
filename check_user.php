<?php
require("db.php");
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $email = $_POST["email"];
    $check = "SELECT email FROM users WHERE email = '$email'";
    $response = $db->query($check);
    if ($response->num_rows != 0) {
        echo "usermatch";
    }else{
        echo "usernotmatch";
    }
}else{
    echo"unauthorised request";
}
?>