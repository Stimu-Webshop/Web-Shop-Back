<?php  
function openDb(): object {
  $ini= parse_ini_file("../config.ini", true);
  $host = $ini['host'];
  $database = $ini['database'];
  $user = $ini['user'];
  $password = $ini['password'];
    try {
        $db = new PDO("mysql:host=$host;dbname=$database;charset=utf8",$user,$password);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $pdoex) {
        returnError($pdoex);
    }
} 

function returnError(PDOException $pdoex): void {
  header('HTTP/1.1 500 Internal Server Error');
  $error = array('error' => $pdoex->getMessage());
  echo json_encode($error);
  exit;
 }

 function selectAsJson(object $db,string $sql): void {
  $query = $db->query($sql);
  $results = $query->fetchAll(PDO::FETCH_ASSOC);
  header('HTTP/1.1 200 OK');
  echo json_encode($results);
}

function selectRowAsJson(object $db,string $sql): void {
  $query = $db->query($sql);
  $results = $query->fetch(PDO::FETCH_ASSOC);
  header('HTTP/1.1 200 OK');
  echo json_encode($results);
}