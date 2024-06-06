<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Account</title>
    <link rel="stylesheet" href="./styles/style.css" />
</head>
<body>
    <h2>Create New Account</h2>

    <form action="" method="post">
        <fieldset>
            <p>ID: <input type="text" name="id" placeholder="Write your ID" maxlength="10" required></p>
            <p>Password: <input type="password" name="pw" placeholder="Write your password" maxlength="10" required></p>
            <p>Name: <input type="text" name="name" placeholder="Write your name" maxlength="10" required></p>
            <p>Age: <input type="text" name="age" maxlength="5" required></p>
            <p>Phone Number: <input type="text" name="phonenum" maxlength="13" required></p>
        </fieldset>
        <br>
        <input type="submit" name="submit" value="CREATE ACCOUNT">
    </form>

    <!-- 이건 잘됨. memberDB 에 잘 들어감 -->
    <?php
    if (isset($_POST['submit'])) {

        $servername = 'localhost';
        $user = 'root';
        $pass = '1234';
        $dbname = 'ensharp';

        $db = new mysqli($servername, $user, $pass, $dbname) or die("Unable to connect");

        $id = $_POST['id'];
        $pw = $_POST['pw'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $phonenum = $_POST['phonenum'];

        $addNewMemberQuery = "INSERT INTO memberdb (id, pw, name, age, phonenum) VALUES ('$id', '$pw', '$name', '$age', '$phonenum')";
        
        mysqli_query($db, $addNewMemberQuery) or die(mysqli_error($db));

        $db->close();

        // pop alert by javascript
        // go back to user_menu.php
        echo '<script type="text/javascript">
            alert("CREATE ACCOUNT SUCCESS");
            window.location="http://localhost/php/LIBRARY_PHP/home_login.php";
            </script>';
    }
    ?>
</body>
</html>
