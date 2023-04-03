<?php

//headers
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

$deleteData = json_decode(file_get_contents('php://input'), true); //
var_dump($deleteData);
//open connection
$pdo = openDb();

try {
    // Begin a transaction
    $pdo->beginTransaction();
    
//SQL for deleting item from shopping cart
    $stmt = $pdo->prepare("DELETE FROM shopping_cart WHERE user_id = :user_id AND product_id = :product_id AND quantity = :quantity");

    // Execute the SQL query to delete the item from the shopping cart for the current user
    $stmt->execute([
        'user_id' => $deleteData['user_id'],
        'product_id' => $deleteData['product_id'],
        'quantity' => $deleteData['quantity']
    ]);
        // Commit the transaction
        $pdo->commit();

        // Send a success response
        http_response_code(200);
        echo json_encode(array("message" => "item deleted successfully."));
    
    } catch (Exception $e) {
        // Rollback the transaction if there was an error
        $pdo->rollBack();
    
        // Send an error response
        http_response_code(500);
        echo json_encode(array("message" => "Error deleting item", "error" => $e->getMessage()));
    }
    //close connection
    $pdo = null;
