<?php
/*  Follow user  */
session_start();
include 'connectdb.php';

if(!empty($_POST["userId"])) {
  $userid = mysqli_real_escape_string($connDB, $_POST["userId"]);

  if(isset($_POST["unfollow"])) {

    $sql = "DELETE FROM Follow
            WHERE userId1=".$_SESSION["userId"]." AND userId2=".$userid;
    $connDB->query($sql);
  }
  else
  {
    $sql = "INSERT INTO Follow (userId1, userId2, followingDate)
            VALUES ('".$_SESSION["userId"]."', '" . $userid . "', CURRENT_TIMESTAMP)";
    $connDB->query($sql);
  }

  header("Location: userProfile.php?id=" . $userid);
}
$connDB->close();
?>
