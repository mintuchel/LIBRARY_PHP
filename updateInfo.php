<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPDATE FORM</title>
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

        $updatingMemberID = "dog";

        $updateMemberQuery = "UPDATE memberDB SET pw = '$pw', name = '$name', age = '$age', phonenum = '$phonenum' WHERE BINARY(id) = '$updatingMemberID'";
        
        mysqli_query($db, $updateMemberQuery) or die(mysqli_error($db));

        $db->close();
    }
    ?>
    
</body>
</html>
