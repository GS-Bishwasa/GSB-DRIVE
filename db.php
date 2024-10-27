<?php
$db = new mysqli("localhost","root","","gsbdrive");
if ($db->connect_error) {
    die( "connection not established");
}
?>