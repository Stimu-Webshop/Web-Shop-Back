<?php   
    require_once '../essentials/functions.php';
    require_once '../essentials/headers.php';
    
    // 17.3 17:05. Toimiva haku databaseen joka tuo kaikki taulukon tuotteet

    try {
        $db = openDb();
        selectAsJson($db, 'select * from product where category_id  = 2');
    } catch (PDOException $pdoex) {
        returnError($pdoex);
    }