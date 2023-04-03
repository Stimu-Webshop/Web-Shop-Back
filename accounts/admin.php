<?php
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

$conn = openDb();

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $orderData = json_decode(file_get_contents('php://input'), true);


    $id = $orderData["id"];
    $name =  $orderData["name"];
    $description =  $orderData["description"];
    $price =  $orderData["price"];
    $image =  $orderData["image"];
    $category =  $orderData["category"];
    $inventory =  $orderData["inventory"];

    $stmt = $conn->prepare("UPDATE product SET name=:name, description=:description, price=:price, img=:image, category_id=:category,inventory=:inventory WHERE id=:id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':inventory', $inventory);

    $stmt->execute();
    echo "Product updated successfully!";
    return;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
/* --------------------------------- */
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
/* ----------------------------------- */
try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $orderData = json_decode(file_get_contents('php://input'), true);

    $id = $orderData["id"];

    $stmt = $conn->prepare("DELETE FROM product WHERE id=:id");
    $stmt->bindParam(':id', $id);

    $stmt->execute();
    echo "Product deleted successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


$pdo = null;
