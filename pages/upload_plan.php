<?php
session_start();
require("../db.php");
$user_email = $_SESSION['user'];

$plan = $_GET['plan'];
$storage = "";

if ($plan =="silver") {
    $storage = 51200;
}elseif ($plan == "gold") {
    $storage = 102400;
}elseif ($plan =="premium") {
    $storage = 0;
}

$purchase_date = date('Y-m-d');
$pd = new DateTime($purchase_date);
$pd->sub(new DateInterval('P30D'));
$ed = $pd->format('Y-m-d');
$update = "UPDATE users SET plans='$plan',storage = '$storage',purchase_date='$purchase_date' expiry_data = '$ed' WHERE email ='$$user_email'";
if($db->query($update)){
header("Location:../profile.php");
}else{
    echo"Update Failed";
}
?>