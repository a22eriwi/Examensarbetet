<?php
require '../vendor/autoload.php';

// Connect to MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");

$database = $mongoClient->Reddit;
$collection = $database->RedditData;

//Create empty erray that recieves the documents from collection
$documents = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $search = trim($_POST['search']);

    $documents = iterator_to_array($collection->find([
        '$text' => ['$search' => $search]
    ]));
}
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
<div class="centrera">
    <h1><a href="home.html">Home</a></h1>
</div>
<div class="sok">
    <div class="centrera">
        <h1 class="dbNamn"><a href="MongoDB.php" id="noUnderline">Search MongoDB</a></h1>
        <form action="" method="post">
            <input id="searchBar" type="text" name="search" placeholder="Search...">
            <button id="searchButton" type="submit">Search</button>
        </form>
    </div>
</div>

<?php
if (!empty($documents) && count($documents) > 0) {
?>
<div id="centerTable">
    <table>
        <tr>
            <th>Subbreddit</th>
            <th>creation_date</th>
            <th>Upvotes</th>
            <th>Title</th>
            <th>Body</th>
            <th>num_comments</th>
            <th>URL</th>
        </tr>

        <?php foreach ($documents as $doc): ?>
            <tr>
                <td><?php echo isset($doc['Subreddit']) ? htmlspecialchars((string)$doc['Subreddit']) : 'N/A'; ?></td>
                <td><?php echo isset($doc['creation_date'])? htmlspecialchars($doc['creation_date']) : 'N/A'; ?></td>
                <td><?php echo isset($doc['Upvotes']) ? htmlspecialchars($doc['Upvotes']) : 'N/A'; ?></td>
                <td><?php echo isset($doc['Title']) ? htmlspecialchars($doc['Title']) : 'N/A'; ?></td>
                <td><?php echo isset($doc['Body']) ? htmlspecialchars($doc['Body']) : 'N/A'; ?></td>
                <td><?php echo isset($doc['num_comments']) ? htmlspecialchars($doc['num_comments']) : 'N/A'; ?></td>
                <td><?php echo isset($doc['URL']) ? htmlspecialchars($doc['URL']) : 'N/A'; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php } ?>

</body>
</html>