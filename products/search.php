<?php

// Replace the database credentials with your own
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database_name";

try {
  // Create connection
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Escape special characters in the search query to prevent SQL injection attacks
  $search_query = $conn->quote('%' . $_GET['q'] . '%');

  // Query to retrieve data from the database based on the search query
  $sql = "SELECT * FROM products WHERE name LIKE $search_query";

  // Prepare the statement
  $stmt = $conn->prepare($sql);

  // Execute the statement
  $stmt->execute();

  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Send the results as JSON
  header('Content-Type: application/json');
  echo json_encode($rows);

} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>
