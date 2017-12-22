<?php
/* Post Tweets */
session_start();
include 'connectDB.php';


header("Location: userProfile.php?id=". $_SESSION["userId"]."&search=".$_POST["searchTweet"] );


?>
