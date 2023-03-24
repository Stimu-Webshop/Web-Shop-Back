<?php

require_once '../essentials/functions.php';
require_once '../essentials/headers.php';


// Retrieve the ID and comment data from the request body
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

if (!isset($data['id']) || !isset($data['comment'])) {
    // Return an error response if the required data is missing
    http_response_code(400);
    $response = array('status' => 'error', 'message' => 'Missing required data');
    echo json_encode($response);
    exit();
}

$id = $data['id'];
$rating = $data['rating'];
$comment = $data['comment'];
$name = $data['name'];


// Process the data as needed (e.g. storing it in a database)

// Open the database connection
$pdo = openDb();

// Prepare the SQL query to insert the review data into the database
$stmt = $pdo->prepare("INSERT INTO product_review (product_id, rating, review_text, review_name) VALUES (:product_id, :rating, :comment, :name)");

// Execute the SQL query
$stmt->execute([
    'product_id' => $id,
    'rating' => $rating,
    'comment' => $comment,
    'name' => $name
    
]);

// Send a response to the client
$response = array('status' => 'success');
echo json_encode($response);

