<?php
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = openDb();
    $userId = json_decode($_GET['userId'], true);
    $requestData = file_get_contents('php://input');
    $userData = json_decode($requestData, true);

    error_log("requestData: $requestData");
    error_log("userData: " . print_r($userData, true));

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


    // Populate userData array with only non-empty fields
    foreach ($userData as $key => $value) {
        if (isset($userData[$key]) && !empty($userData[$key])) {
          $userData[$key] = $value;
        }
      }

    var_dump($userData);

    error_log("userData after populating: " . print_r($userData, true));

    // Check if username already exists
    if (!empty($userData['username'])) {
      $stmt = $db->prepare('SELECT id FROM user WHERE username = :username');
      $stmt->execute(array(':username' => $userData['username']));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo 'Checked for username';
      if ($row && $row['id'] != $userId) {
        http_response_code(409);
        echo json_encode(array('error' => 'Username already exists.'));
        exit();
      }
    }

    // Check if current password is correct before updating it
    if (!empty($userData['current_password'])) {
      $stmt = $db->prepare('SELECT password FROM user WHERE id = :userId');
      $stmt->execute(array(':userId' => $userId));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      echo 'Checked for password';
      if (!password_verify($userData['current_password'], $row['password'])) {
        http_response_code(401);
        echo json_encode(array('error' => 'Invalid password.'));
        exit();
      }

      // Hash and update new password if present
      if (!empty($userData['new_password'])) {
        $hashedPassword = password_hash($userData['new_password'], PASSWORD_DEFAULT);
        $stmt = $db->prepare('UPDATE users SET password = :password WHERE id = :userId');
        $stmt->execute(array(':password' => $hashedPassword, ':userId' => $userId));
        echo 'Updated password';
    }

      unset($userData['current_password'], $userData['new_password']);
    }
    echo 'Before updating';
    // Update remaining fields
    $set = array();
    foreach ($userData as $key => $value) {
      if (!is_null($value)) {
        $set[] = "$key = :$key";
      }
    }
   
	var_dump($userId);
	var_dump($set);
	echo(count($set));
    
    if (count($set) > 0) {
        $sql = "UPDATE user SET " . implode(",", $set) . " WHERE id = :userId";
        $stmt = $db->prepare($sql);
        $userData['userId'] = $userId;
        $stmt->execute($userData);
        echo 'actually updated data';
      }
    }

	echo 'Didnt update';