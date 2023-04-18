<?php
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

$conn = openDb();

$orderData = json_decode($_POST['id']);

$id = isset($orderData["id"]) ? $orderData["id"] : null;

if ($id !== null) {
    $stmt = $conn->prepare("UPDATE orders SET delivered = 1 WHERE row_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        http_response_code(200);
        echo json_encode(array("message" => "Order delivered status updated successfully."));
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to update order delivered status."));
    }

    $stmt->close();
    return;
} else {
    selectAsJson($conn, 'select * from orders order by delivered asc');
}


