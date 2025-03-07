<?php
require '../vendor/autoload.php';

use MongoDB\Client;

// Connect to MongoDB
$mongoClient = new Client("mongodb://localhost:27017");

echo "Connected successfully to MongoDB!";

// Select database and collection
$database = $mongoClient->myDatabase;
$collection = $database->myCollection;

$documents = $collection->find();

?>
