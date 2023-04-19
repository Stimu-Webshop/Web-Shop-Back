<?php
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

$conn = openDb();

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


$conn = null;
