<?php
require("./scripts/common.php");
?>

<?php
checkSession();
$userID = $_SESSION["userID"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Borrow History</title>
    <link rel="stylesheet" href="./styles/style.css" />
</head>
<body>
    <?php echo '<h2>' . $userID. '\'s borrow history </h2>'; ?>

    <?php
        $db = getDBConnection();

        $borrower_id = $userID;
        
        // get books from historyDB which borrower borrowed and didn't return
        $query = "SELECT book_id FROM historyDB WHERE borrower_id = '$borrower_id' AND returned = FALSE ORDER BY book_id";
        
        $result = mysqli_query($db, $query) or die(mysqli_error($db));

        echo "<table>";
        echo '<tr><th>BookID</th><th>Name</th><th>Author</th><th>Publisher</th><th>Price</th><th>InStock</th><th>PublishDate</th><th>ISBN</th></tr>';
                    
        if ($result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {

                // extract the book_id from each row
                $book_id = $row['book_id'];
                
                // using another query to get the real book data from bookDB
                $query = "SELECT * FROM bookDB WHERE id = '$book_id'";
                        
                $curBookResult = mysqli_query($db, $query);
                
                if ($curBookResult->num_rows > 0) {
                    while($curBook = mysqli_fetch_array($curBookResult)) {
                        echo "<tr><td>" . $curBook["id"] . "</td><td>". $curBook["name"] . "</td><td>" . $curBook["author"] . "</td><td>" . $curBook["publisher"] . "</td><td>". $curBook["price"] . "</td><td>" . $curBook["instock"] . "</td><td>" . $curBook["date"] . "</td><td>". $curBook["isbn"] . "</td><tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No data available</td></tr>";
                }

                $curBookResult->close();
            }
        } else {
            echo "<tr><td colspan='8'>No data available</td></tr>";
        }
        echo "</table>";

        $result->close();
        $db->close();
    ?>
</body>
</html>
