<?php
//Composer
require '../vendor/autoload.php';

use Couchbase\Cluster;
use Couchbase\ClusterOptions;
use Couchbase\QueryOptions;

// Connect to Couchbase Server
$connectionString = "couchbase://127.0.0.1";
$options = new ClusterOptions();
$options->credentials("root", "hejhej");

$cluster = new Cluster($connectionString, $options);
$bucket = $cluster->bucket("reddit");
$collection = $bucket->defaultCollection();

$searchQuery = isset($_POST['search']) ? trim($_POST['search']) : '';

$results = [];

if (!empty($searchQuery)) {
    try {
        // Positional parameter SELECT query
        $queryString = "SELECT * FROM `reddit` WHERE Subreddit = $1";
        $queryOptions = new QueryOptions();
        $queryOptions->positionalParameters([$searchQuery]);

        $queryResult = $cluster->query($queryString, $queryOptions);

        foreach ($queryResult->rows() as $rad) {
            $results[] = $rad['reddit'];
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        <title>Couchbase</title>
        <link href="style.css" rel="stylesheet">
    </head>
<body>
<div class="centrera">
    <h1><a href="home.html">Home</a></h1>
</div>
<div class="sok">
    <div class="centrera">
        <h1 class="dbNamn"><a href="Couchbase.php" id="noUnderline">Search Couchbase</a></h1>
        <form action="" method="post">
            <input id="searchBar" type="text" name="search" placeholder="Search...">
            <button id="searchButton" type="submit">Search</button>
        </form>
    </div>
</div>
<?php if (isset($results) && !empty($results)) { ?>
    <div id="centerTable">
        <table>
        <tr>
            <th>Subreddit</th>
            <th>Creation Date</th>
            <th>Upvotes</th>
            <th>Title</th>
            <th>Body</th>
            <th>Number of Comments</th>
            <th>URL</th>
        </tr>
        <?php 
            foreach ($results as $column): ?>
                <tr>
                    <td><?php echo isset($column['Subreddit']) ? htmlspecialchars((string)$column['Subreddit']) : 'N/A'; ?></td>
                    <td><?php echo isset($column['creation_date']) ? htmlspecialchars($column['creation_date']) : 'N/A'; ?></td>
                    <td><?php echo isset($column['Upvotes']) ? htmlspecialchars($column['Upvotes']) : 'N/A'; ?></td>
                    <td><?php echo isset($column['Title']) ? htmlspecialchars($column['Title']) : 'N/A'; ?></td>
                    <td><?php echo isset($column['Body']) ? htmlspecialchars($column['Body']) : 'N/A'; ?></td>
                    <td><?php echo isset($column['num_comments']) ? htmlspecialchars($column['num_comments']) : 'N/A'; ?></td>
                    <td><?php echo isset($column['URL']) ? htmlspecialchars($column['URL']) : 'N/A'; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php }?>
</body>
</html>