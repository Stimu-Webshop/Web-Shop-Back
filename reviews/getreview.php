<?php

require_once '../essentials/functions.php';
require_once '../essentials/headers.php';
try{
$db = openDb();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pageid = $_GET['pageid'];

$sql = "SELECT * FROM product_review WHERE product_id = $pageid";

$stmt = $db->prepare($sql);
$stmt->execute();

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($rows);

} catch(PDOException $e) {
echo "Connection failed: " . $e->getMessage();
}