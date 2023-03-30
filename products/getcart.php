<?php   
    require_once '../essentials/functions.php';
    require_once '../essentials/headers.php';
    
    //Get the shopping cart from the database
    $userId = $_GET['UserId'];
    try {
        $db = openDb();
        selectAsJson($db, "select * from shopping_cart where user_id = $userId");
    } catch (PDOException $pdoex) {
        returnError($pdoex);
    }