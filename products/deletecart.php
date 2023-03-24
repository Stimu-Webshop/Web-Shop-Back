<?php

require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

// Assuming the order data is sent in the request body as JSON data
$orderData = json_decode(file_get_contents('php://input'), true);

// Open the database connection using the openDb function
$pdo = openDb();

try {
    // Begin a transaction
    $pdo->beginTransaction();
    
// Prepare the SQL query to delete the contents of the shopping cart for the current user
    $stmt = $pdo->prepare("DELETE FROM shopping_cart WHERE user_id = :user_id");

    // Execute the SQL query to delete the contents of the shopping cart for the current user
    $stmt->execute([
        'user_id' => $orderData['user_id']
    ]);

    // Commit the transaction
    $pdo->commit();

    // Send a success response
    http_response_code(200);
    echo json_encode(array("message" => "Order placed successfully."));

} catch (Exception $e) {
    // Rollback the transaction if there was an error
    $pdo->rollBack();

    // Send an error response
    http_response_code(500);
    echo json_encode(array("message" => "Error placing order.", "error" => $e->getMessage()));
}

// Close the database connection
$pdo = null;

?>