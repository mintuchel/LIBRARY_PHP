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
    <title>Borrow Book</title>
    <link rel="stylesheet" href="./styles/style.css" />
</head>

<body>
    <div class="content">
        <!-- have to get the books first -->
        <!-- get the books from db and show it on screen -->
        <?php
            $db = getDBConnection();

            $selectBookQuery = "SELECT * FROM bookDB WHERE requested = FALSE";
            
            // get rows from database that match with selectBookQuery form DB
            $result = mysqli_query($db, $selectBookQuery) or die(mysqli_error($db));
            $num_books = mysqli_num_rows($result);

            // tr = table row
            // th = table header
            // td = table data
            // have to use = because we are assigning the initial value
            $table = <<<ENDHTML
                <div class="table-container">
                    <h2>Library Book List</h2>
                    <table>
                        <tr> 
                            <th>BookID</th>
                            <th>BookName</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Price</th>
                            <th>InStock</th>
                            <th>PublishDate</th>
                            <th>ISBN</th>
                        </tr>
            ENDHTML;

            // loop through the results
            while($row = mysqli_fetch_assoc($result)){
                extract($row);
                // have to add strings to the original herodoc variable so use .=
                $table .= <<<ENDHTML
                    <tr>
                        <td> $id </td>
                        <td> $name </td>
                        <td> $author </td>
                        <td> $publisher </td>
                        <td> $price </td>
                        <td> $instock </td>
                        <td> $date </td>
                        <td> $isbn </td>
                    </tr>
                ENDHTML;
            }

            $table .= <<<ENDHTML
                    </table>
                </div>
            ENDHTML;
            
            echo $table;
        ?>

        <!-- make user to put id of the wanted book -->
        <div class="form-container">
            <form method="post" action="">
                <label for="book_id">Book you want to borrow:</label><br>
                <input type="text" id="book_id" name="book_id" required><br>
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>

        <!-- if submit button is clicked, php does the action below -->
        <?php
        if (isset($_POST['submit'])) {

            $db = getDBConnection();

            // already extracted userID from the top when checking if session is valid
            $borrower_id = $userID;
            
            $book_id = $_POST['book_id'];

            $checkIfBookExistsQuery = "SELECT EXISTS (SELECT TRUE FROM bookDB WHERE id = $book_id AND deleted = FALSE AND requested = FALSE)";

            $result = mysqli_query($db, $checkIfBookExistsQuery);

            $row = mysqli_fetch_row($result);
            
            // if book doesnt exist we have to end the php code
            if($row[0] == 0){
                echo '<script type="text/javascript">
                    alert("THIS BOOK DOESNT EXIST!");
                    </script>';
                // have to end current php code
                $db->close();
                exit();
            }

            $borrowBookQuery = "INSERT INTO historyDB (borrower_id, book_id, returned) VALUES('$borrower_id', '$book_id', FALSE)";
            
            mysqli_query($db, $borrowBookQuery) or die(mysqli_error($db));

            $result->close();
            $db->close();
        
            // pop alert by javascript
            // go back to user_menu.php
            echo '<script type="text/javascript">
                alert("BORROW BOOK SUCCESS!");
                window.location="http://localhost/php/LIBRARY_PHP/user_menu.php";
                </script>';
        }
        ?>
    </div>
</body>
</html>
