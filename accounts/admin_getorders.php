<?php
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

$conn = openDb();
selectAsJson($conn, 'select * from orders order by delivered asc');


