<?php
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

$conn = openDb();

$orderData = json_decode(file_get_contents('php://input'), true);

$stmt = $conn->prepare('INSERT INTO orders ( order_date, user_id, ordered_product_id, product_quantity, delivered)
    SELECT NOW(), shopping_cart.user_id, shopping_cart.product_id, shopping_cart.quantity, 0
    FROM shopping_cart
    WHERE shopping_cart.user_id = :user_id');

$stmt->execute([
':user_id' => $orderData['user_id'],
]);
