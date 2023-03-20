<!-- Tommin testi versio -->
<?php
    require_once '../essentials/functions.php';
    require_once '../essentials/headers.php';
// Replace the database credentials with your own

// Create connection
// Create a MySQL database connection
$db = openDb();

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Escape special characters in the search query to prevent SQL injection attacks
$search_query = mysqli_real_escape_string($db, $_POST['q']);

// Query to retrieve data from the database based on the search query
$sql = "SELECT * FROM product WHERE name LIKE '%$search_query%'";

$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
    // Convert the result set into an array of associative arrays
    $rows = array();
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    // Send the results as JSON
    header('Content-Type: application/json');
    echo json_encode($rows);
} else {
    echo "0 results";
}

mysqli_close($db);

