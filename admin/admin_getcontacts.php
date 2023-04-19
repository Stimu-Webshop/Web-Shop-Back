<?php
require_once '../essentials/functions.php';
require_once '../essentials/headers.php';

$conn = openDb();

selectAsJson($conn, 'select * from contact_form');