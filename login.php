<?php
// 1. session start must be called at the beginning of each script where session data is accessed or modified
// 2. It ensures a session is available and allows access to session variables through the $_SESSION superglobal array.
// 3. Placing session_start() at the top of your script, before any output, ensures session functionality works correctly.
session_start();
?>

<html>
    <head>
        <title>LIBRARY</title>
    </head>
    <body>
        <form action="userMenu.php" method="post">
            <p>Enter your id:
                <input type="text" name="userId"/>
            </p>
            <p>Enter your password:
                <input type="password" name="userPw"/>
            </p>
            <p>
                <input type="submit" name="login" value="LOGIN"/>
            </p>
        </form>
        <a href="createAccount.php">Create New Account</a>

        <?php
        if (isset($_POST['login']))
        {
        $servername = 'localhost';
        $user = 'root';
        $pass = '1234';
        $dbname = 'ensharp';

        // get db connection object by mysqli command
        $db = new mysqli($servername, $user, $pass, $dbname) or die("Unable to connect");

        $id = $_POST['userID'];
        $pw = $_POST['userPw'];

        $checkIfValidLoginQuery = "SELECT EXISTS (SELECT TRUE FROM memberDB WHERE id='$userId' AND pw='$userPw')";
        
        $result = mysqli_query($db, $checkIfValidLoginQuery) or die(mysqli_error($db));

        $row = mysqli_fetch_row($result);

        if($row[0] == 1){
            // set session variable "userID" to track who logged in
            $_SESSION['userID'] = $id;
            // set session variable "authuser" to know if this is valid login state from other pages
            $_SESSION['authuser'] = 1;

            // redirect to userMenu.php
            header("Location: userMenu.php");
            exit();
        }else{
            echo "Invalid login";
        }

        $result->free_result();

        $db->close();
        }
        ?>
    </body>
</html>