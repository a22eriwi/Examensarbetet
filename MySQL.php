<?php
$servername = "localhost";
$username = "root";

try {
    //MySQL Database connection established
    $conn = new PDO("mysql:host=$servername;dbname=reddit", $username);

    // PDO error mode set to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['search'])){
        $sokOrd = $_POST['search'];

        //Prepared SQL statement with placeholder
        $stmt = $conn->prepare("SELECT * FROM redditDataset25 WHERE Subreddit= :sokOrd");

        //Search term bound to the placeholder
        $stmt->bindParam(':sokOrd', $sokOrd, PDO::PARAM_STR);

        $stmt->execute();

        $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}catch (PDOException $e){
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        <title>MySQL</title>
        <link href="style.css" rel="stylesheet">
    </head>
<body>
<div class="centrera">
    <h1><a href="home.html">Home</a></h1>
</div>
<div class="sok">
    <div class="centrera">
        <h1 class="dbNamn"><a href="MySQL.php" id="noUnderline">Search MySQL</a></h1>
        <form action="" method="post" id="searchForm">
            <input id="searchBar" type="text" name="search" placeholder="Search...">
            <button id="searchButton" type="submit">Search</button>
        </form>
    </div>
</div>
<?php if (isset($resultat) && !empty($resultat)) { ?>
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
            <?php foreach ($resultat as $column): ?>
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