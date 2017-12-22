<?php
/* Post Tweets */
session_start();
include 'connectDB.php';

if(!empty($_POST["tweet"])) {
  $tweetText = mysqli_real_escape_string($connDB, $_POST["tweet"]);

  $sql = "INSERT INTO tweets (userId, tweetText, postedDate)
  VALUES ('".$_SESSION["userId"]."', '" . $tweetText . "', CURRENT_TIMESTAMP)";

  $result=$connDB->query($sql);

}
$connDB->close();

header("Location: userProfile.php?id=" . $_SESSION["userId"]);
?>
