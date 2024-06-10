<?php

function checkSession()
{
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
}

function getDBConnection()
{
    $servername = 'localhost';
    $user = 'root';
    $pass = '1234';
    $dbname = 'ensharp';

    // get db connection object by mysqli command
    $db = new mysqli($servername, $user, $pass, $dbname) or die("Unable to connect");

    return $db;
}

?>