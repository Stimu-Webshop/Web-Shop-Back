<?php

// Assuming the shopping cart array is sent in the request body as JSON data
$cartData = json_decode(file_get_contents('php://input'), true);

// Open the database connection using the openDb function
$pdo = openDb();

// Prepare the SQL query to insert the shopping cart data into the database
$stmt = $pdo->prepare("INSERT INTO shopping_cart (id, user_id, product_id, quantity, total) VALUES (:id, :user_id, :product_id, :quantity, :total)");

// Iterate over the shopping cart items and execute the SQL query for each item
foreach ($cartData as $item) {
    $stmt->execute([
        'user_id' => $item['user_id'],
        'product_id' => $item['id'],
        'quantity' => $item['quantity'],
        'id' => 1,
        'total' => $item['total']
    ]);
}

// Close the database connection
$pdo = null;

// TEHTÄVIÄ MUUTOKSIA MUISTIINPANOT
// Poista shopping session taulu, lisää userid ja total shoppingcart ta3uluun