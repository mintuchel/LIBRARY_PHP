<?php
require("./scripts/common.php");
?>

<?php
checkSession();
$userID = $_SESSION["userID"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPDATE FORM</title>
    <link rel="stylesheet" href="./styles/style.css" />
</head>
<body>
    <?php echo '<h2> UPDATE ' . $userID. '\'s INFO </h2>'; ?>

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
        $db = getDBConnection();

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
