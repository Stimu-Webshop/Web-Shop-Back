<?php
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

$conn = openDb();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed.'));
    exit;
  } 

  try {
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    // Display error message if unable to connect to the database
    die("Connection failed: " . $e-> getMessage());
  }

    $orderData = json_decode(file_get_contents('php://input'), true);
     $ids = implode(',', $orderData);

    $stmt = $conn->prepare("UPDATE orders SET delivered = 1 WHERE row_id IN ($ids)");
    

if (!$stmt) {
    error_log("Error preparing SQL statement: " . $conn->error);
    http_response_code(500);
    echo json_encode(array('error' => 'Error preparing SQL statement.'));
    exit;
}
    $stmt->execute();

if (!$stmt->execute()) {
    error_log("Error executing SQL statement: " . $stmt->error);
    http_response_code(500);
    echo json_encode(array('error' => 'Error executing SQL statement.'));
    exit;
}

    if ($stmt->affected_rows > 0) {
        http_response_code(200);
        echo json_encode(array("message" => "Order delivered status updated successfully."));
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to update order delivered status."));
    }

    $stmt->close();
