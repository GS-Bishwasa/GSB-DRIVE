<?php
require("../db.php");
$id = $_POST["h_id"];
$status = $_POST["h_status"];
$table = $_POST['h_folder'];

$update = "UPDATE $table SET star='$status' WHERE id = '$id'";
if($db->query("$update")){
    echo "Success";
}else{
    echo "Failed";
}

?>