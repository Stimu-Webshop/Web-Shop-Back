<?php
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

// ONGELMA : EI SAA OIKEAA USERIDTÄ FRONTENDILTÄ
// PALAUTTAA ARVON NULL

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $db = openDb();
    $userId = json_decode($_GET['userId'], true);
    $userIdNum = $data['userId'];
    $requestData = file_get_contents('php://input');
    $userData = array_filter(json_decode($requestData, true));

    var_dump($userId);
    $userData = array(
        'username' => $userData['username'] ?? null,
        'first_name' => $userData['first_name'] ?? null,
        'last_name' => $userData['last_name'] ?? null,
        'email' => $userData['email'] ?? null,
        'telephone' => $userData['telephone'] ?? null,
        'address' => $userData['address'] ?? null,
        'city' => $userData['city'] ?? null,
        'postal_code' => $userData['postal_code'] ?? null,
        'country' => $userData['country'] ?? null,
        'current_password' => $userData['current_password'] ?? null,
        'new_password' => $userData['new_password'] ?? null
    );

    // Populate non-empty userData array
    $nonEmptyUserData = array();
    foreach ($userData as $key => $value) {
        if (isset($userData[$key]) && !empty($userData[$key])) {
            $nonEmptyUserData[$key] = $value;
        }
    }

    // Check if username already exists
    if (!empty($nonEmptyUserData['username'])) {
        $stmt = $db->prepare('SELECT id FROM user WHERE username = :username');
        $stmt->execute(array(':username' => $nonEmptyUserData['username']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo 'Checked for username';
        if ($row && $row['id'] != $userId) {
            http_response_code(409);
            echo json_encode(array('error' => 'Username already exists.'));
            exit();
        }
    }

    // Check if current password is correct before updating it
    if (!empty($nonEmptyUserData['current_password'])) {
        $stmt = $db->prepare('SELECT password FROM user WHERE id = :userId');
        $stmt->execute(array(':userId' => $userId));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo 'Checked for password';
        if (!password_verify($nonEmptyUserData['current_password'], $row['password'])) {
            http_response_code(401);
            echo json_encode(array('error' => 'Invalid password.'));
            exit();
        }

        // Hash and update new password if present
        if (!empty($nonEmptyUserData['new_password'])) {
            $hashedPassword = password_hash($nonEmptyUserData['new_password'], PASSWORD_DEFAULT);
            $stmt = $db->prepare('UPDATE user SET password = :password WHERE id = :userId');
            $stmt->execute(array(':password' => $hashedPassword, ':userId' => $userId));
            echo 'Updated password';
        }

        // Remove password fields from non-empty userData array
        unset($nonEmptyUserData['current_password'], $nonEmptyUserData['new_password']);
    }

// Update remaining fields

$set = array();

$params = array();
foreach ($nonEmptyUserData as $key => $value) {
    $set[] = "$key = :$key";
    $params[":$key"] = $value;
}
var_dump($params);

if (count($set) > 0) {
    $sql = "UPDATE user SET " . implode(",", $set) . " WHERE id = :userId";
    $stmt = $db->prepare($sql);
    $params['userId'] = $userIdNum;
    $stmt->execute($params);
    $rowCount = $stmt->rowCount();
    echo $sql;
    echo "Number of affected rows: $rowCount";
} else {
    echo 'No fields to update';
}
}