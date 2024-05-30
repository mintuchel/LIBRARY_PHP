<?php
session_start();
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

        // 이쪽만 바꾸면 됨
        $borrower_id = 'dog';
        
        $book_id = $_POST['book_id'];

        $query = "INSERT INTO historyDB (borrower_id, book_id, returned) VALUES('$borrower_id', '$book_id', FALSE)";
        
        mysqli_query($db, $query) or die(mysqli_error($db));

        $db->close();
    }
    ?>  
</body>
</html>