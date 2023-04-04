<?php
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

$conn = openDb();

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $orderData = json_decode(file_get_contents('php://input'), true);

 
    $name =  $orderData["name"];
    $description =  $orderData["description"];
    $price =  $orderData["price"];
    $image =  $orderData["image"];
    $category =  $orderData["category"];
    $inventory =  $orderData["inventory"];

    $stmt = $conn->prepare("INSERT INTO product (name, description, price, img, category_id, inventory) VALUES (:name, :description, :price, :image, :category, :inventory)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':inventory', $inventory);

    $stmt->execute();
    echo "Product added successfully!";
    return;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;