<?php   
    require_once '../essentials/functions.php';
    require_once '../essentials/headers.php';
    
    try {
        $db = openDb();
        selectAsJson($db, 'select * from product_category');
    } catch (PDOException $pdoex) {
        returnError($pdoex);
    }