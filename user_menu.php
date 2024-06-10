<?php
require("./scripts/common.php");
?>

<?php
checkSession();
$userID = $_SESSION["userID"];
?>

<html>
    <head>
        <title>USER MENU</title>
        <link rel="stylesheet" href="./styles/style.css" />
    </head>
    <body>
        <fieldset>
            
            <?php echo '<h1> Hello ' . $userID. '!</h1>'; ?>

            <p><a href="book_borrow.php" style="text-decoration: none; color: blue;">borrow books</a></p>
            <p><a href="book_return.php" style="text-decoration: none; color: blue;">return books</a></p>
            <p><a href="user_history.php" style="text-decoration: none; color: blue;">check history</a></p>
            <p><a href="user_update.php" style="text-decoration: none; color: blue;">update info</a></p>
            
            <form action="" method="get">
                <input type="submit" name="logout" value="LOGOUT">
            </form>
        
        </fieldset>
        
        <?php
            if (isset($_GET['logout'])){
                unset($_SESSION['userID']);
                unset($_SESSION['authuser']);
                header("Location: home_login.php");
                exit();
            }
        ?>
    </body>
</html>