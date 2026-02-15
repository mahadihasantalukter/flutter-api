<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
include "connection.php";

$method = $_SERVER['REQUEST_METHOD'];

// --- ১. ডাটা আপলোড করার অংশ (POST Method) ---
if($method == 'POST'){
    
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    $imagePath = 'upload/'.$image;

    if (!is_dir('upload')) {
    mkdir('upload', 0777, true);
}

    if(move_uploaded_file($tmp_name, $imagePath)){
        
        $sql = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$image')";
        
        if (mysqli_query($conn, $sql)) {
            echo json_encode(["status" => "success", "message" => "Data Uploaded Successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database Error: " . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Image Upload Failed to Folder"]);
    }

} 
// --- ২. ডাটা লিস্ট দেখার অংশ (GET Method) ---
else if($method == 'GET'){
    
    $sql = "SELECT * FROM products ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    $products = array();

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            // আপনার সার্ভারের বর্তমান URL এবং ফোল্ডার পাথ এখানে দিন
            $row['image_url'] = "http://192.168.0.108/flutter/api/upload/" . $row['image'];
            $products[] = $row;
        }
        echo json_encode($products);
    } else {
        echo json_encode([]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
}
?>