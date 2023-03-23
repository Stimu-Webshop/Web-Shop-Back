<?php
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

$conn = openDb();

try {
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  // Display error message if unable to connect to the database
  die("Connection failed: " . $e->getMessage());
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the form data
  $username = $_POST['username'];
  $password = $_POST['password'];
  $firstName = $_POST['first_name'];
  $lastName = $_POST['last_name'];
  $email = $_POST['email'];
  $telephone = $_POST['telephone'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $postalCode = $_POST['postal_code'];
  $country = $_POST['country'];
  
  // Check if username already exists
  $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
  $stmt->execute(['username' => $username]);
  $existingUser = $stmt->fetch();
  if ($existingUser) {
    // Username already exists, display error message to user
    http_response_code(409); // Set response status code to 409 Conflict
    echo "Error: Username already exists.";
    exit();
  }
  
  // Insert the form data into the database
  try {
    $stmtt = $conn->prepare("INSERT INTO user (username, password, first_name, last_name, email, telephone, address, city, postal_code, country) VALUES (:username, :password, :firstName, :lastName, :email, :telephone, :address, :city, :postalCode, :country)");
    $stmtt->execute([
      'username' => $username,
      'password' => $password,
      'firstName' => $firstName,
      'lastName' => $lastName,
      'email' => $email,
      'telephone' => $telephone,
      'address' => $address,
      'city' => $city,
      'postalCode' => $postalCode,
      'country' => $country,
    ]);
    
    // Display success message to the user
    echo "Registration successful!";
  } catch (PDOException $e) {
    // Display error message if unable to insert data into the database
    die("Insertion failed: " . $e->getMessage());
  }
}
?>
