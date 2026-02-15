<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
include "connection.php";

$method = $_SERVER['REQUEST_METHOD'];

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
        echo json_encode([]);
    }
} 

else if($method == 'POST'){
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
    $username   = isset($_POST['username']) ? $_POST['username'] : '';
    $action     = isset($_POST['action']) ? $_POST['action'] : ''; 

    if($product_id != '' && $username != ''){
        if($action == 'add'){
            // কোয়ান্টিটি বাড়ানো
            $sql = "UPDATE addtocart SET quantity = quantity + 1 WHERE username = '$username' AND product_id = '$product_id'";
        } 
        else if($action == 'remove'){
            // কোয়ান্টিটি কমানো (১ এর বেশি থাকলে)
            $sql = "UPDATE addtocart SET quantity = quantity - 1 WHERE username = '$username' AND product_id = '$product_id' AND quantity > 1";
        } 
        else if ($action == 'delete') {
            // ডিলিট করা
            $sql = "DELETE FROM addtocart WHERE username = '$username' AND product_id = '$product_id'";
        }
        
        if (mysqli_query($conn, $sql)) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
        }
    }
}
?>