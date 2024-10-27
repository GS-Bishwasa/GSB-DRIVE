<?php
session_start();
require("../db.php");
$user_email = $_SESSION['user'];
$plan = $_GET['plan'];
$amt = $_GET['amt'];
$res = $db->query("SELECT * FROM users WHERE email = '$user_email'");
$data = $res->fetch_array();
$name = $data["full_name"];

require("../src/Instamojo.php");
$api = new Instamojo\Instamojo(API_KEY, AUTH_TOKEN, 'https://test.instamojo.com/api/1.1/');
// Enter API KEY And AUTH TOKEN Before proceeding

try {
    $response = $api->paymentRequestCreate(array(
        "purpose" => "GSB Drive ".$plan." Plan",
        "amount" => $amt,
        "send_email" => true,
        "email" => $user_email,
        "buyer_name"=> $name,
        "redirect_url" => "http://localhost/GSB DRIVE/pages/upload_plan.php?plan=".$plan
        ));
$mail_url = $response['longurl'];
header('Location:$main_url');
}
catch (Exception $e) {
    print('Error: ' . $e->getMessage());
}

?>