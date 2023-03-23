<?php   
    require_once '../essentials/functions.php';
    require_once '../essentials/headers.php';
    
    //Get the shopping cart from the database
    
    try {
        $db = openDb();
        selectAsJson($db, 'select * from shopping_cart');
    } catch (PDOException $pdoex) {
        returnError($pdoex);
    }