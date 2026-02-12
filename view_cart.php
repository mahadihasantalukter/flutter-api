<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
include "connection.php";

$method = $_SERVER['REQUEST_METHOD'];

// --- ১. ডাটা লিস্ট দেখার অংশ (GET Method) ---
if($method == 'GET'){
    
    $username = isset($_GET['username']) ? $_GET['username'] : '';

    if($username != ''){
        $sql = "SELECT * FROM addtocart WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $cartItems = array();

        while($row = mysqli_fetch_assoc($result)) {
            $cartItems[] = $row;
        }
        echo json_encode($cartItems);
    } else {
        echo json_encode(["status" => "error", "message" => "Username is required"]);
    }

} 
// --- ২. ডাটা ডিলিট করার অংশ (POST Method) ---
else if($method == 'POST'){
    
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';

    if($product_id != '' && $username != ''){
        $sql = "DELETE FROM addtocart WHERE username = '$username' AND product_id = '$product_id'";
        
        if (mysqli_query($conn, $sql)) {
            echo json_encode(["status" => "success", "message" => "Item removed"]);
        } else {
            echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Missing parameters"]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
}
?>