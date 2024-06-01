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
        <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
    </style>
    </head>
    <body>
        <fieldset>
            
            <?php echo '<h1> Hello ' . $userID. '!</h1>'; ?>

            <p><a href="book_borrow.php">borrow books</a></p>
            <p><a href="book_return.php">return books</a></p>
            <p><a href="user_history.php">check history</a></p>
            <p><a href="user_update.php">update info</a></p>
            
            <form action="" method="post">
                <input type="submit" name="logout" value="LOGOUT">
            </form>
        
        </fieldset>
        
        <?php
            if (isset($_POST['logout'])){
                unset($_SESSION['userID']);
                unset($_SESSION['authuser']);
                header("Location: home_login.php");
                exit();
            }
        ?>
    </body>
</html>