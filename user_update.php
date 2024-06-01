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
    <title>UPDATE FORM</title>
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
    <h2>UPDATE YOUR INFO</h2>
    <form action="" method="post">
        <fieldset>
            <p>new pw: <input type="text" name="pw" maxlength="10" required /></p>
            <p>new name: <input type="text" name="name" maxlength="10" required></p>
            <p>new age: <input type="text" name="age" maxlength="5" required></p>
            <p>new phonenum: <input type="text" name="phonenum" maxlength="20" required></p>
        </fieldset>
        <br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <!-- 여기도 잘됨 -->
    <?php
    if (isset($_POST['submit']))
    {
        $servername = 'localhost';
        $user = 'root';
        $pass = '1234';
        $dbname = 'ensharp';

        // getting db connection object by mysqli command
        $db = new mysqli($servername, $user, $pass, $dbname) or die("Unable to connect");

        $pw = $_POST['pw'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $phonenum = $_POST['phonenum'];

        $updatingMemberID = $userID;

        $updateMemberQuery = "UPDATE memberDB SET pw = '$pw', name = '$name', age = '$age', phonenum = '$phonenum' WHERE BINARY(id) = '$updatingMemberID'";
        
        mysqli_query($db, $updateMemberQuery) or die(mysqli_error($db));

        $db->close();

        // pop alert by javascript
        // go back to user_menu.php
        echo '<script type="text/javascript">
            alert("USER UPDATE SUCCESS!");
            window.location="http://localhost/php/LIBRARY_PHP/user_menu.php";
            </script>';
    }
    ?>
</body>
</html>
