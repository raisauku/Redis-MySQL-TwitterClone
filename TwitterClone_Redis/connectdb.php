<?php
//Connecting to Redis server on localhost
 $redis = new Redis();
 $redis->connect('127.0.0.1', 6379);
 //echo "Connection to redis server sucessfully";
 //check whether server is running or not
 //echo "redis Server is running: ".$redis->ping();
 $connDB =  $redis;


 /*$servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "twitterclonedb";
$connDB = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($connDB->connect_error) {
    die("Connection to database failed: " . $connDB->connect_error);
}*/
?>
