<?php

 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "twitterclonedbsmall";

$connDB = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connDB->connect_error) {
    die("Connection to database failed: " . $connDB->connect_error);
}
?>
