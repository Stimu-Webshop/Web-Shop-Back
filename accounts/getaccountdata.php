<?php
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

$conn = openDb();

try {
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  // Display error message if unable to connect to the database
  die("Connection failed: " . $e-> getMessage());
}

// Make sure the request method is GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed.'));
    exit;
  } 

// Get the user ID from the query string
$data = json_decode($_GET['userId'], true);
$userId = $data['userId'];

// Prepare the SQL statement
$stmt = $conn->prepare('SELECT username, first_name, last_name, email, telephone, address, city, postal_code, country FROM user WHERE id = :userId');
$stmt->bindParam(':userId', $userId);
$stmt->execute();

// Fetch the user from the database
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Return the user as JSON
echo json_encode($user);;


