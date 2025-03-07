<?php
require '../vendor/autoload.php';

use MongoDB\Client;

// Connect to MongoDB
$mongoClient = new Client("mongodb://localhost:27017");

// Select database and collection
$database = $mongoClient->local;
$collection = $database->startup_log;

$documents = $collection->find();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>MongoDB</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="sok">
    <div class="centrera">
        <h1 class="dbNamn">Search MongoDB</h1>
        <form action="/search" method="get">
            <input id="searchBar" type="text" name="search" placeholder="Search...">
            <button id="searchButton" type="submit">Search</button>
        </form>
    </div>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Data</th>
    </tr>

    <?php foreach ($documents as $doc): ?>
        <tr>
            <td><?php echo isset($doc['_id']) ? $doc['_id'] : 'N/A'; ?></td>
            <td><?php echo isset($doc['hostname']) ? $doc['hostname'] : 'N/A'; ?></td> <!-- Change 'name' to your field -->
        </tr>
    <?php endforeach; ?>

</table>

</body>
</html>