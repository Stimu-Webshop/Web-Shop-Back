<?php
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

$conn = openDb();

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_POST["id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $image = $_POST["image"];
    $category = $_POST["category"];
    $inventory = $_POST["inventory"];
    $is_featured = $_POST["is_featured"];

    $stmt = $conn->prepare("UPDATE product SET name=:name, description=:description, price=:price, img=:image, category_id=:category,inventory=:inventory, is_featured=:is_featured WHERE id=:id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':inventory', $inventory);
    $stmt->bindParam(':is_featured', $is_featured);

    $stmt->execute();
    echo "Product updated successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
/* --------------------------------- */
try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $image = $_POST["image"];
    $category = $_POST["category"];
    $inventory = $_POST["inventory"];
    $is_featured = $_POST["is_featured"];

    $stmt = $conn->prepare("INSERT INTO product (name, description, price, img, category_id, inventory, is_featured) VALUES (:name, :description, :price, :image, :category, :inventory, :is_featured)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':inventory', $inventory);
    $stmt->bindParam(':is_featured', $is_featured);

    $stmt->execute();
    echo "Product added successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
/* ----------------------------------- */
try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_POST["id"];

    $stmt = $conn->prepare("DELETE FROM product WHERE id=:id");
    $stmt->bindParam(':id', $id);

    $stmt->execute();
    echo "Product deleted successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


$pdo = null;
