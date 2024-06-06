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