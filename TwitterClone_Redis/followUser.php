<?php
/*  Follow user  */
session_start();
include 'connectdb.php';

if(!empty($_POST["userId"])) {

  //$userid = mysqli_real_escape_string($connDB, $_POST["userId"]);

  //**Fatemeh
  //echo $_POST["userId"]."<br>"; //follower id
  //echo $_SESSION["userId"]; //current loged in user
  //$userid = $_POST["userId"];
  //**Fatemeh

  if(isset($_POST["unfollow"])) {

    //remove the follwing from uer's followings
    $connDB->HINCRBY("user:".$_SESSION["userId"],"following",-1);
    $connDB->zrem("followings:".$_SESSION["userId"],$_POST["userId"]);
    //delete followings tweets
    $allTweets = $connDB-> ZREVRANGEBYSCORE("home:".$_SESSION["userId"],"+inf","-inf");
    foreach ($allTweets as $tweetId)
     {
       if($connDB->hget("tweet:".$tweetId,"userId")==$_POST["userId"])
       {
         $connDB->zrem("home:".$_SESSION["userId"],$tweetId);
       }
     }
    //remove the current user from follower's list of the other user
    $connDB->zrem("followers:".$_POST["userId"],$_SESSION["userId"]);
    $connDB->HINCRBY("user:".$_POST["userId"],"follower", -1);


    /*$sql = "DELETE FROM Follow
            WHERE userId1=".$_SESSION["userId"]." AND userId2=".$userid;
    $connDB->query($sql);*/
  }
  else//follow button
  {
    $currentTime = date("d-m-Y H:i:s");
    $currenttimestamp = substr($currentTime,6,4).substr($currentTime,0,2).
    substr($currentTime,3,2).substr($currentTime,11,2).
    substr($currentTime,14,2).substr($currentTime,17,2);
    //add the follwing to user's followings
    $connDB->zadd("followings:".$_SESSION["userId"], $currenttimestamp,$_POST["userId"]);
    $followingNum = $connDB->HINCRBY("user:".$_SESSION["userId"],"following",1);
    //get the followings' tweets
    $allTweets = $connDB-> ZREVRANGEBYSCORE("home:".$_POST["userId"],"+inf","-inf");
    foreach ($allTweets as $tweetId)
     {
       if($connDB->hget("tweet:".$tweetId,"userId")==$_POST["userId"])
       {
         $tweetpostedDate = $connDB->hget("tweet:".$tweetId,"postedDate");
         $timestamp = substr($tweetpostedDate,0,4).substr($tweetpostedDate,5,2).
         substr($tweetpostedDate,8,2).substr($tweetpostedDate,11,2).
         substr($tweetpostedDate,14,2).substr($tweetpostedDate,17,2);
         $connDB->zadd("home:".$_SESSION["userId"],$timestamp,$tweetId);
       }
     }
    //add the current user to follower's list of the other user
    $connDB->zadd("followers:".$_POST["userId"],  $currenttimestamp,$_SESSION["userId"]);
    $connDB->HINCRBY("user:".$_POST["userId"],"follower",1);
//**Fatemeh**

    /*$sql = "INSERT INTO Follow (userId1, userId2, followingDate)
            VALUES ('".$_SESSION["userId"]."', '" . $userid . "', CURRENT_TIMESTAMP)";
    $connDB->query($sql);*/
  }

  header("Location: userProfile.php?id=" .$_POST["userId"]);
}
$connDB->close();
?>
