<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
include "connection.php";
if($_SERVER['REQUEST_METHOD' ] == 'POST'){
    $product_id = $_POST['id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    
    $price = $_POST['price'];
    $image_url = $_POST['image'];
    // check if product already added to cart
    $check = "SELECT * FROM addtocart WHERE uaername = '$username' AND product_id = '$product_id'";
    $result = mysqli_query($conn, $check);

    if(mysqli_num_rows($result) > 0){
        // product already added to cart
       $sql = "UPDATE addtocart SET quantity = quantity + 1 WHERE uaername = '$username' AND product_id = '$product_id'";
    } else {
        // product not added to cart
        $sql = "INSERT INTO addtocart (product_id, name, username, price, image_url) VALUES ('$product_id', '$name', '$username', '$price', '$image_url')";
    }
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success", "message" => "Product added to cart successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add product to cart: " . $conn->error]);
    
    }

}
?>