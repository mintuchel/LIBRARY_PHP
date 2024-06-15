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
    <title>Return Book Form</title>
    <link rel="stylesheet" href="./styles/style.css" />
</head>
<body>
    <div class="content">
        
        <?php echo '<h2>' . $userID. '\'s returnable books </h2>'; ?>

        <?php
            $db = getDBConnection();

            $borrower_id = $userID;
            
            // get books from historyDB which borrower borrowed and didnt return
            $getCertainMemberBorrowHistoryquery = "SELECT book_id FROM historyDB WHERE borrower_id = '$borrower_id' AND returned = FALSE ORDER BY book_id";
            
            $result = mysqli_query($db, $getCertainMemberBorrowHistoryquery) or die(mysqli_error($db));

            echo '<div class="table-container">';
            echo '<table>';
            echo '<tr><th>BookID</th><th>Name</th><th>Author</th><th>Publisher</th><th>Price</th><th>InStock</th><th>PublishDate</th><th>ISBN</th></tr>';

            if ($result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {

                    // extract the book_id from each row
                    $book_id = $row['book_id'];

                    // using another query to get the real book data from bookDB
                    $query = "SELECT * FROM bookDB WHERE id = '$book_id'";
                            
                    $curBookResult = mysqli_query($db, $query) or die(mysqli_error($db));

                    if ($curBookResult->num_rows > 0) {
                        while($curBook = mysqli_fetch_array($curBookResult)) {
                            echo "<tr><td>" . $curBook["id"] . "</td><td>". $curBook["name"] . "</td><td>" . $curBook["author"] . "</td><td>" . $curBook["publisher"] . "</td><td>". $curBook["price"] . "</td><td>" . $curBook["instock"] . "</td><td>" . $curBook["date"] . "</td><td>". $curBook["isbn"] . "</td><tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No data available</td></tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='8'>No data available</td></tr>";
            }
            echo '</table>';
            echo '</div>';

            $db->close();
        ?>

        <!-- action 에 돌아갈 html 을 써놓으면 됨! -->
        <div class="form-container">
            <form method="post" action="">
                <label for="returnBookId">Enter the Book ID you want to return</label>
                <input type="text" id="returnBookId" name="returnBookId" required>
                <input type="submit" name="return" value="Return">
            </form>
        </div>

        <?php
        if (isset($_POST['return'])) {
            $db = getDBConnection();

            $borrower_id = $userID;
            $book_id = $_POST['returnBookId'];
            
            $checkIfUserBorrowedQuery = "SELECT EXISTS (SELECT TRUE FROM historyDB WHERE borrower_id = '$borrower_id' AND book_id = '$book_id' AND returned = FALSE)";

            $result = mysqli_query($db, $checkIfUserBorrowedQuery) or die(mysqli_error($db));

            $row = mysqli_fetch_row($result);

            // if user didnt borrow we have to end the php code
            if($row[0] == 0){
                echo '<script type="text/javascript">
                alert("YOU DIDNT BORROW THIS BOOK!");
                </script>';
                // have to end current php code
                $db->close();
                exit();
            }

            // delete borrow history of this borrower == returning book
            $deleteBorrowHistoryQuery = "DELETE FROM historyDB WHERE borrower_id = '$borrower_id' AND book_id = '$book_id' AND returned = FALSE";
            
            $result = mysqli_query($db, $deleteBorrowHistoryQuery) or die(mysqli_error($db));

            // pop alert by javascript
            // go back to user_menu.php
            echo '<script type="text/javascript">
                alert("RETURN BOOK SUCCESS!");
                window.location="http://localhost/php/LIBRARY_PHP/user_menu.php";
                </script>';
        }
        ?>
    </div>
</body>
</html>
