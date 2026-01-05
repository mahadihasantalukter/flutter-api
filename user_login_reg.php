<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
include "connection.php";
error_reporting(0);

if (!isset($_POST['action'])) {
    echo json_encode(["status" => "error", "message" => "No action defined"]);
    exit();
}
$action = $_POST['action'];

// register page
if($action == "register"){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if($conn->query($sql) === TRUE){
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}

// login page
else if($action == "login"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $email = $conn->real_escape_string($email);

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user['password']) { 
    echo json_encode(["status" => "success", "user" => $user]); 
} else {
    echo json_encode(["status" => "error", "message" => "Invalid password"]);
}
    } else {
        echo json_encode(["status" => "error", "message" => "User not found"]);
    }
}
?>