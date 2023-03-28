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

// Make sure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(array('error' => 'Method not allowed.'));
  exit;
} 

$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'];
$password = $data['password'];

// Check that the username and password were provided
if (!isset($username) || !isset($password)) {
  http_response_code(400);
  echo json_encode(array('error' => 'Username and password are required.'));
  exit;
}

// Prepare the SQL query to get the user data based on the username
$stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check that a user was found with the provided username
if (!$user) {
  http_response_code(401);
  echo json_encode(array('error' => 'Invalid username or password.'));
  exit;
}

// Verify the password
if (!password_verify($password, $user['password'])) {
  http_response_code(401);
  echo json_encode(array('error' => 'Invalid username or password.'));
echo 'osuu tähän';
  exit;
}

// User is authorized
echo json_encode(array('message' => 'User is authorized.'));
