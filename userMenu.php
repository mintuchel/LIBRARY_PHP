<?php
session_start();

// check to see if user has logged in with a valid passowrd
if($_SESSION['authuser'] != 1){
    echo 'Sorry but you dont have permission to view this page!';
    exit();
}
?>

<html>
    <head>
        <title>USER MENU</title>
    </head>
    <body>
    <!-- getting userId variable value from recieved POST message -->
    <?php
    echo '<h1> Hello' . $_POST['userId'] . '!</h1>';
    ?>
        <ol>
            <li><a href="borrowBook.php">borrow books</a></li>
            <li><a href="returnBook.html">return books</a></li>
            <li><a href="checkHistory.php">check history</a></li>
            <li><a href="updateInfo.php">update info</a></li>
        </ol>
</html>