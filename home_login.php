<?php
    // 1. session start must be called at the beginning of each script to use session data passed between forms
    // 2. It ensures a session is available and allows access to session variables through the $_SESSION superglobal array.
    // 3. Placing session_start() at the top of your script, before any output, ensures session functionality works correctly.

    // if already exists, it uses passed session
    // if not, it creates new session
    session_start();
?>

<html>
    <head>
        <title>[LIBRARY]</title>
        <link rel="stylesheet" href="./styles/style.css" />
    </head>
    <body>

        <h1>Login</h1>

        <fieldset>
            <!-- leave actionURL blank to only redirect if login is valid -->
            <form action="" method="post">
                <p>Enter your id:
                    <input type="text" name="userID"/>
                </p>
                <p>Enter your password:
                    <input type="password" name="userPW"/>
                </p>
                <p>
                    <input type="submit" name="login" value="Login"/>
                </p>
                <a href="home_createAccount.php">Create Account</a>
            </form>
        </fieldset>

        <?php
            if (isset($_POST['login']))
            {
            $servername = 'localhost';
            $user = 'root';
            $pass = '1234';
            $dbname = 'ensharp';

            // get db connection object by mysqli command
            $db = new mysqli($servername, $user, $pass, $dbname) or die("Unable to connect");

            $userID = $_POST['userID'];
            $userPW = $_POST['userPW'];
    
            $checkIfValidLoginQuery = "SELECT EXISTS (SELECT TRUE FROM memberDB WHERE id='$userID' AND pw='$userPW')";
        
            $result = mysqli_query($db, $checkIfValidLoginQuery) or die(mysqli_error($db));

            $row = mysqli_fetch_row($result);
        
            if($row[0] == 1){
                // set session variable "userID" to track who logged in
                $_SESSION["userID"] = $userID;
                // set session variable "authuser" to know if this is valid login state from other pages
                $_SESSION["authuser"] = true;

                // redirect to userMenu.php
                header("Location: user_menu.php");
                exit();
            }else{
                echo "<script>showPopUp();</script>";
            }

            $result->free_result();

            $db->close();
            }
        ?>
        <script>
            function showPopUp(){
                window.alert("INVALID LOGIN");
            }
        </script>
    </body>
</html>