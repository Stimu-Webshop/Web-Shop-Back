<?php

require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

try {
  // Create connection
  $conn = openDb();
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Escape special characters in the search query to prevent SQL injection attacks
  $id = (int)$_GET['id'];

  // Query to retrieve data from the database based on the search query
  $sql = "SELECT * FROM product WHERE id = :id";

  // Prepare the statement
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id);

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
