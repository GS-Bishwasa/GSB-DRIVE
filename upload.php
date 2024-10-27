<?php
require("db.php");
session_start();

$user_email = $_SESSION['user'];


$file = $_FILES["data"];
$filename = strtolower($file['name']);
$location = $file['tmp_name'];
$f_size = round($file['size'] / 1024 / 1024, 2);

$get_details = "SELECT * FROM users WHERE email = '$user_email'";
$res = $db->query($get_details);
$user_data = $res->fetch_assoc();
$user_id_folder = "user_" . $user_data["id"];
$total_storage = $user_data['storage'];
$old_used_storage = $user_data['used_storage'];
$free_space = $total_storage - $old_used_storage;
    if (file_exists('data/' . $user_id_folder . '/' . $filename)) {
        echo json_encode(array("msg"=>"File Already Exists"));
    } else {
        $upload = move_uploaded_file($location, 'data/' . $user_id_folder . '/' . $filename);
        if ($upload) {
            $file_store = "INSERT INTO $user_id_folder(file_name,file_size)VALUES('$filename','$f_size')";
            if ($db->query("$file_store")) {

                $fs_sql = "SELECT sum(file_size) AS uds FROM $user_id_folder";
                $response = $db->query($fs_sql);
                $aa = $response->fetch_assoc();
                $total_used_file_size = round($aa['uds'], 2);
                $update = "UPDATE users SET used_storage = '$total_used_file_size' WHERE email = '$user_email'";
                if ($db->query($update)) {
                   echo json_encode(array("msg"=>"Upload Success","used_storage"=>$total_used_file_size));
                    
                } else {
                    echo json_encode(array("msg"=>"Used Storage Not Store In Table"));
                }
            } else {
                echo json_encode(array("msg"=>"File Doesnot Store In Table"));
            }
        } else {
            echo json_encode(array("msg"=>"Upload Failed"));

        }

    }


?>