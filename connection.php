<?php
$server = "localhost";
$username = "root";
$password = "";
$db = "alldata";

$conn = new mysqli($server, $username, $password, $db);
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>