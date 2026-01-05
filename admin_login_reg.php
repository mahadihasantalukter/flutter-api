<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
include "connection.php";
error_reporting(0);

if (!isset($_POST['action'])) {
    echo json_encode(["status" => "error", "message" => "No action defined"]);
    exit();
}
// register page
$action = $_POST['action'];
if($action == "register"){
    $name = $_POST['name'];
    $phone = $_POST['phone_number'];
    $email = $_POST['email'];
    $shopname = $_POST['shop_name'];
    $address = $_POST['address'];
    

    $sql = "INSERT INTO shop_admin (name, phone_number, email,shop_name, address,) VALUES ('$name', '$email', '$password', '$address', '$phone', '$shopname')";
    if($conn->query(($sql)) == TRUE){
        echo json_encode(["status" => "success"]);
    }
    else{
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}


// login page
else if ($action == 'login') {
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];

    $result = $conn->query("SELECT * FROM shop_admin WHERE email='$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($phone == $user['phone_number']) {
            echo json_encode(["status" => "success", "user" => $user]);
        } else {
            echo json_encode(["status" => "error", "message" => "Wrong password"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "User not found"]);
    }
}
?>