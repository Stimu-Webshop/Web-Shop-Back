<?php

require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

try {
    // Create connection
    $conn = openDb();
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    // Escape special characters in the search query to prevent SQL injection attacks
    if (isset($_GET['id'])) {
      $id = $conn->quote($_GET['id']);
    } else {
      $id = 1;
    }
    if (isset($_GET['comment'])) {
      $comment = $conn->quote($_GET['comment']);
    } else {
      $comment = 'No comment';
    }
    // $rating = $conn->quote($_GET['rating']);
  
    // Query to retrieve data from the database based on the search query
    $sql = "INSERT INTO product_review VALUES ( NULL, $id, 5, $comment)";
  
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