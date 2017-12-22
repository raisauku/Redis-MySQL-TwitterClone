<?php
/* Post Tweets */
session_start();
//include 'connectDB.php';
include ('connectdb.php');


if(!empty($_POST["tweet"])) {
  //$tweetText = mysqli_real_escape_string($connDB, $_POST["tweet"]);
  //**Fatemeh
  $tweetId = $connDB->hget("num", "tweet");
  $connDB->hincrby("num", "tweet", 1);
  $tweetText = $_POST["tweet"];
  $redis->hset("tweet:".$tweetId, "tweetId", $tweetId);
  $redis->hset("tweet:".$tweetId, "tweetText", $tweetText);
  $redis->hset("tweet:".$tweetId, "userId", $_SESSION["userId"]);
  $currentTime = date("Y-m-d H:i:s");
  $redis->hset("tweet:".$tweetId, "postedDate", $currentTime);
  //update user hash
  $connDB->hincrby("user:".$_SESSION["userId"],"posts",1);
  //update home sorted set
  $timestamp = substr($currentTime,0,4).substr($currentTime,5,2).
  substr($currentTime,8,2).substr($currentTime,11,2).
  substr($currentTime,14,2).substr($currentTime,17,2);
  $redis->Zadd("home:".$_SESSION["userId"], $timestamp,$tweetId);
  //update other followings' home
  $followerSetKey = "followers:".$_SESSION["userId"];
  $allfollowers = $connDB-> ZREVRANGEBYSCORE($followerSetKey,"+inf","-inf");
  foreach ($allfollowers as $follower)
   {
     $connDB->zadd("home:".$follower,$timestamp,$tweetId); 
   }
  //Redis------------------------------------------

  //**Fatemeh


  /*$sql = "INSERT INTO tweets (userId, tweetText, postedDate)
  VALUES ('".$_SESSION["userId"]."', '" . $tweetText . "', CURRENT_TIMESTAMP)";

  $result=$connDB->query($sql);*/

}
$connDB->close();

header("Location: userProfile.php?id=" . $_SESSION["userId"]);
?>
