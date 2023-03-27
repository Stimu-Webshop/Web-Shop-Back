<?php
//Tää on vielä kesken, mut saattaa toimia, kun vaihdetaan tauluista otsikot

require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

// Get the order data from the request body
$order = json_decode(file_get_contents('php://input'), true);

// Update the inventory quantity in the database
$pdo = openDb();

$stmt = $pdo->prepare('UPDATE product SET inventory = inventory - :quantity WHERE product_id = :product_id');
$stmt->execute([
  ':product_id' => $order['product_id'],
  ':quantity' => $order['quantity']
]);

// Send a response indicating success
header('Content-Type: application/json');
echo json_encode(['success' => true]);
