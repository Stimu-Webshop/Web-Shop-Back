<?php
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

// Get the order data from the request body
$order = json_decode(file_get_contents('php://input'), true);

// Update the inventory quantity in the database
$pdo = openDb();

$stmt = $pdo->prepare('UPDATE product
                       JOIN shopping_cart ON shopping_cart.product_id = product.id
                       SET product.inventory = product.inventory - shopping_cart.quantity
                       WHERE shopping_cart.user_id = :user_id');
$stmt->execute([
  ':user_id' => $order['user_id'],
]);

// Send a response indicating success
header('Content-Type: application/json');
echo json_encode(['success' => true]);
