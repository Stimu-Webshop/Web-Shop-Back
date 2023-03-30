<?php
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

// Get the raw POST data
$data = file_get_contents('php://input');

// Parse the JSON-encoded data into an associative array
$contactData = json_decode($data, true);

// Extract the fields from the associative array
$firstName = $contactData['firstName'];
$lastName = $contactData['lastName'];
$email = $contactData['email'];
$address = $contactData['address'];
$phone = $contactData['phone'];
$message = $contactData['message'];

// Connect to the database
$dsn = openDb();

// Insert the data into the contact_form table
try {
    $query = "INSERT INTO contact_form (first_name, last_name, email, address, phone, message) VALUES (:firstName, :lastName, :email, :address, :phone, :message)";

    $stmt = $dsn->prepare($query);

    $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
    $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);

    $stmt->execute();

    echo "Kiitos viestistäsi!";

} catch (PDOException $e) {
    echo "Virhe tietokantaan tallennettaessa: " . $e->getMessage();
}
?>
