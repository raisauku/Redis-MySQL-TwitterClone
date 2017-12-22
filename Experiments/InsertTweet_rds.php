<?php
include 'connectRedis.php';

$tweetText = "Hello! This is a test!";
$tweetId = 0;
$numOfTweets=10000;
$res=0;
$currentTime = date("Y-m-d H:i:s");
$timestamp = substr($currentTime,0,4).substr($currentTime,5,2).
substr($currentTime,8,2).substr($currentTime,11,2).
substr($currentTime,14,2).substr($currentTime,17,2);

//------------------------------------------------------------------------------
echo "Number of inserted tweets : ".$numOfTweets."<br>";
for ($i=1; $i<=1; $i++)
{
  $start=microtime(TRUE);//START

  for($j=1; $j<=$numOfTweets; $j++)
  {
    $connRedis->hset("tweet:".$tweetId, "tweetId", $tweetId);
    $connRedis->hset("tweet:".$tweetId, "tweetText", $tweetText);
    $connRedis->hset("tweet:".$tweetId, "userId", $j);
    $connRedis->hset("tweet:".$tweetId, "postedDate", $currentTime);
    //update user's hash
    $connRedis->hincrby("user:".$userId,"posts",1);
    //update home's sorted set
    $connRedis->Zadd("home:".$userId, $timestamp,$tweetId);
    //update other followers' homes
    $allfollowers = $connRedis-> ZREVRANGEBYSCORE("followers:".$userId,"+inf","-inf");
    foreach ($allfollowers as $follower)
     {
       $connRedis->zadd("home:".$follower,$timestamp,$tweetId);
     }
  }

  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Iteration ".$i." : ".$timeNeeded."<br>";
  $res= $res + $timeNeeded;
  }
  $res = $res/5;
  echo "Average time for the query : ".  round($res,7). " microseconds"."<br>"."<br>";//END

?>
