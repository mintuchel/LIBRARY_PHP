<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book Form</title>
</head>
<body>
    <h2>Borrow History</h2>

    <?php
        $servername = 'localhost';
        $user = 'root';
        $pass = '1234';
        $dbname = 'ensharp';

        $db = new mysqli($servername, $user, $pass, $dbname) or die("Unable to connect");

        $borrower_id = 'dog';
        
        // get books from historyDB which borrower borrowed and didnt return
        $getCertainMemberBorrowHistoryquery = "SELECT book_id FROM historyDB WHERE borrower_id = '$borrower_id' AND returned = FALSE";
        
        $result = mysqli_query($db, $getCertainMemberBorrowHistoryquery) or die(mysqli_error($db));

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

    <!-- action 에 돌아갈 html 을 써놓으면 됨! -->
    <form method="post" action="">
        <br>
        <input type="text" name="returnId">
        <input type="submit" name="return" value="return">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $servername = 'localhost';
        $user = 'root';
        $pass = '1234';
        $dbname = 'ensharp';

        $db = new mysqli($servername, $user, $pass, $dbname) or die("Unable to connect");

        $borrower_id = 'dog';
        $book_id = '3';
        
        // delete borrow history of this borrower == returning book
        $deleteBorrowHistoryQuery = "DELETE FROM historyDB WHERE borrower_id = '$borrower_id' AND book_id = '$book_id' AND returned = FALSE";
        
        $result = mysqli_query($db, $deleteBorrowHistoryQuery) or die(mysqli_error($db));
    }
    ?>

</body>
</html>