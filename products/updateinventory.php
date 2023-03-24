<?php
//Tää on vielä kesken, mut saattaa toimia, kun vaihdetaan tauluista otsikot

require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

// Get the order data from the request body
$order = json_decode(file_get_contents('php://input'), true);

// Update the inventory quantity in the database
$pdo = openDb();

$stmt = $pdo->prepare('UPDATE product SET inventory_quantity = inventory_quantity - :quantity WHERE id = :id');
$stmt->execute([
  ':id' => $order['productId'],
  ':quantity' => $order['quantity']
]);

// Send a response indicating success
header('Content-Type: application/json');
echo json_encode(['success' => true]);
