<?php
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

if (isset($_POST['submit'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $dsn = openDb();

    try {
        $query = "INSERT INTO contact_form (first_name, last_name, email, address, phone, message) VALUES (:first_name, :last_name, :email, :address, :phone, :message)";

        $stmt = $dsn->prepare($query);

        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);

        $stmt->execute();

        echo "Kiitos viestistäsi!";

    } catch (PDOException $e) {
        echo "Virhe tietokantaan tallennettaessa: " . $e->getMessage();
    }
}
?>
