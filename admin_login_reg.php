<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
include "connection.php";

// ডেভেলপমেন্টের সময় এরর দেখার জন্য এটি অন রাখতে পারেন
// error_reporting(E_ALL); 
// ini_set('display_errors', 1);

if (!isset($_POST['action'])) {
    echo json_encode(["status" => "error", "message" => "No action defined"]);
    exit();
}

$action = $_POST['action'];

if ($action == 'login') {
   
    if (!isset($_POST['name']) || !isset($_POST['phone'])) {
        echo json_encode(["status" => "error", "message" => "Name and Phone are required"]);
        exit();
    }

    $name = $_POST['name'];
    $phone = $_POST['phone'];

    
    $stmt = $conn->prepare("SELECT * FROM user_admin WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        
        if ($phone == $user['phone']) {
            
            unset($user['phone']); 
            echo json_encode(["status" => "success", "user" => $user]);
        } else {
            echo json_encode(["status" => "error", "message" => "Wrong phone number"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "User not found"]);
    }
    
    $stmt->close();
}
$conn->close();
?>