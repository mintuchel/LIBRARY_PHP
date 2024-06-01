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
    <title>Borrow Book</title>
</head>
<body>

    <!-- have to get the books first -->
    <!-- get the books from db and show it on screen -->
    <?php
        $servername = 'localhost';
        $user = 'root';
        $pass = '1234';
        $dbname = 'ensharp';

        // get connection object first
        $db = new mysqli($servername, $user, $pass, $dbname) or die("Unable to connect");

        $selectBookQuery = "SELECT * FROM bookDB WHERE requested = FALSE";
        
        // get rows from database that match with selectBookQuery form DB
        $result = mysqli_query($db, $selectBookQuery) or die(mysqli_error($db));
        $num_books = mysqli_num_rows($result);

        // tr = table row
        // th = table header
        // td = table data
        // have to use = because we are assigning the initial value
        $table = <<<ENDHTML
            <div style = "text-align: center;">
                <h2>You can borrow these books</h2>
                <table border="1" cellpadding="2" cellspacing="2"
                style="width:70%; margin-left:auto; margin-right:auto;">
                    <tr> 
                        <th>BookDI</th>
                        <th>BookName</th>
                        <th>Author</th>
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
                </tr>
            ENDHTML;
        }

        $table .= <<<ENDHTML
        </table>
        <p> $num_books Books </p>
        </div>
        ENDHTML;

        echo $table;
    ?>

    <!-- make user to put id of the wanted book -->
    <form method="post" action="">
        <label>book you want to borrow</label><br>
        <input type="text" id="book_id" name="book_id" required ><br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <!-- if submit button is clicked, php does the action below -->
    <?php
    if (isset($_POST['submit'])) {

        $servername = 'localhost';
        $user = 'root';
        $pass = '1234';
        $dbname = 'ensharp';

        $db = new mysqli($servername, $user, $pass, $dbname) or die("Unable to connect");

        // already extracted userID from the top when checking if session is valid
        $borrower_id = $userID;
        
        $book_id = $_POST['book_id'];

        $borrowBookQuery = "INSERT INTO historyDB (borrower_id, book_id, returned) VALUES('$borrower_id', '$book_id', FALSE)";
        
        mysqli_query($db, $borrowBookQuery) or die(mysqli_error($db));

        $db->close();
    
        // pop alert by javascript
        // go back to user_menu.php
        echo '<script type="text/javascript">
            alert("BORROW BOOK SUCCESS!");
            window.location="http://localhost/php/LIBRARY_PHP/user_menu.php";
            </script>';
    }
    ?>  
</body>
</html>