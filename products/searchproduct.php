<?php 
    require_once '../essentials/functions.php';
    require_once '../essentials/headers.php';

// Tää ei vittu toimi (17.3 17:04) katotaa myöhemmi jos korjais, varmaa eri versioki vielä pilvessä - samppa


// Retrieve the search term from the React frontend
$searchTerm = $_POST['searchTerm'];

// Create a MySQL database connection
$db = openDb();

// Check the connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Construct the SQL query to search for items in the database that include the search term
$sql = "SELECT * FROM product WHERE name LIKE CONCAT('%', $searchTerm, '%')";


// Execute the SQL query
$result = mysqli_query($db, $sql);

// Loop through the results and output them as JSON data
$searchResults = array();

while($row = mysqli_fetch_assoc($result)) {
    $searchResults[] = $row;
}

echo json_encode($searchResults);

// Close the database connection
mysqli_close($db);

?>