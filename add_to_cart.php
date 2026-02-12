<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ডাটা রিসিভ করা
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
    $username   = isset($_POST['username']) ? $_POST['username'] : '';
    $name       = isset($_POST['name']) ? $_POST['name'] : '';
    $price      = isset($_POST['price']) ? $_POST['price'] : '';
    $image_url  = isset($_POST['image_url']) ? $_POST['image_url'] : '';

    // ডাটাবেসে চেক করা (টেবিল নাম addtocart হলে)
    $check = "SELECT * FROM addtocart WHERE username = '$username' AND product_id = '$product_id'";
    $result = mysqli_query($conn, $check);

    if ($result && mysqli_num_rows($result) > 0) {
        // পরিমাণ বাড়ানো
        $sql = "UPDATE addtocart SET quantity = quantity + 1 WHERE username = '$username' AND product_id = '$product_id'";
    } else {
        // সমাধান: আপনার স্ক্রিনশট অনুযায়ী কলামের নাম 'name' এবং 'image'
        // এখানে কলাম সংখ্যা (৬টি) এবং ভ্যালু সংখ্যা (৬টি) একদম সমান রাখা হয়েছে
        $sql = "INSERT INTO addtocart (username, product_id, name, price, image, quantity) 
                VALUES ('$username', '$product_id', '$name', '$price', '$image_url', 1)";
    }

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success", "message" => "Added to cart successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}
?>