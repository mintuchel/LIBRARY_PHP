<?php
// use session that is passed from recent php file
session_start();

// check session variable to see if "userId" variable is set
// check session variable to see if its valid session
if (!isset($_SESSION["userID"]) || $_SESSION["authuser"] !== true) {
    echo $_SESSION["userID"];
    echo $_SESSION["authuser"];
    echo 'Sorry, but you don\'t have permission to view this page!';
    exit();
}

// if valid, save userID session variable to html variable
$userID = $_SESSION["userID"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Check Borrow History</h2>

    <?php
        $servername = 'localhost';
        $user = 'root';
        $pass = '1234';
        $dbname = 'ensharp';

        $db = new mysqli($servername, $user, $pass, $dbname) or die("Unable to connect");

        $borrower_id = $userID;
        
        // get books from historyDB which borrower borrowed and didnt return
        $query = "SELECT book_id FROM historyDB WHERE borrower_id = '$borrower_id' AND returned = FALSE";
        
        $result = mysqli_query($db, $query) or die(mysqli_error($db));

        echo "<table border='3'>";
        echo "<tr><th>BookID</th><th>Name</th><th>Author</th></tr>";

        if ($result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {

                // extract the book_id from each row
                $book_id = $row['book_id'];
                
                // using another query to get the real book data from bookDB
                $query = "SELECT * FROM bookDB WHERE id = '$book_id'";
                        
                $curBookResult = mysqli_query($db, $query) or die(mysqli_error($db));
                
                if ($curBookResult->num_rows > 0) {
                    while($curBook = mysqli_fetch_array($curBookResult)) {
                        echo "<tr><td>" . $curBook["id"] . "</td><td>". $curBook["name"] . "</td><td>" . $curBook["author"] . "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No data available</td></tr>";
                }
            }
        } else {
            echo "<tr><td colspan='3'>No data available</td></tr>";
        }
        echo "</table>";

        $db->close();
    ?>  
</body>
</html>