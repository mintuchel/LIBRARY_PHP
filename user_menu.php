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

<html>
    <head>
        <title>USER MENU</title>
    </head>
    <body>
        <?php
            echo '<h1> Hello ' . $userID. '!</h1>';
        ?>
        <ol>
            <li><a href="borrowBook.php">borrow books</a></li>
            <li><a href="returnBook.html">return books</a></li>
            <li><a href="checkHistory.php">check history</a></li>
            <li><a href="updateInfo.php">update info</a></li>
        </ol>

        <form action="" method="post">
            <input type="submit" name="logout" value="LOGOUT">
        </form>
        
        <?php
            if (isset($_POST['logout'])){
                unset($_SESSION['userID']);
                unset($_SESSION['authuser']);
                header("Location: login.php");
            }
        ?>
    </body>
</html>