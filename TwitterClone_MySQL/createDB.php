<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname ="twitterclonedb";

$connDB = new mysqli($servername, $username, $password);

if ($connDB->connect_error) {
    die("Connection failed: " . $connDB->connect_error);
}
echo "Connected successfully<br />";

// Create database
$sql = "CREATE DATABASE " . $dbname;
if ($connDB->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error in creating database: " . $connDB->error ;
}

// Connect to database
$connDB = new mysqli($servername, $username, $password, $dbname);
if ($connDB->connect_error) {
    die("Connection failed: " . $connDB->connect_error);
}
echo 'Connected successfully to database<br />';

//Creating the tables of the DATABASE

//Table "users"
$sql = "CREATE TABLE Users (
        userId INT AUTO_INCREMENT,
        firstName VARCHAR(25) NOT NULL,
        lastname VARCHAR(25) NOT NULL,
        email VARCHAR(50) NOT NULL,
        password VARCHAR(50) NOT NULL,
        signupDate TIMESTAMP,
        PRIMARY KEY(userid),
        UNIQUE(email))";

$result=$connDB->query($sql);
if ($result === TRUE) {
    echo "Table Users created. ";
} else {
    echo "Error creating table: " . $connDB->error;
}

//Table "tweets"
$sql = "CREATE TABLE Tweets (
        tweetId INT AUTO_INCREMENT,
        userId INT NOT NULL,
        tweetText VARCHAR(30) NOT NULL,
        postedDate TIMESTAMP,
        PRIMARY KEY (tweetId),
        FOREIGN KEY (userId) REFERENCES Users(userId))";

$result=$connDB->query($sql);
if ($result === TRUE) {
    echo "Table Tweets created. ";
} else {
    echo "Error creating table: " . $connDB->error;
}

//Table "Follow"
$sql = "CREATE TABLE Follow (
        userId1 INT NOT NULL,
        userId2 INT NOT NULL,
        followingdate TIMESTAMP,
        CONSTRAINT pk_Followid PRIMARY KEY (userId1, userId2),
        FOREIGN KEY (userId1) REFERENCES Users(userId),
        FOREIGN KEY (userId2) REFERENCES Users(userId))";

$result=$connDB->query($sql);
  if ($result === TRUE) {
    echo "Table Follow created. ";
} else {
    echo "Error creating table: " . $connDB->error;
}

$connDB->close();
?>
