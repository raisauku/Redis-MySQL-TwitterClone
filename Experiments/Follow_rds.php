<?php
include 'connectRedis.php';

$numOfFollow=10000;
$res=0;
$currentTime = date("Y-m-d H:i:s");
$timestamp = substr($currentTime,0,4).substr($currentTime,5,2).
substr($currentTime,8,2).substr($currentTime,11,2).
substr($currentTime,14,2).substr($currentTime,17,2);

echo "Number of follow : ".$numOfFollow."<br>";
//-----------------------------------------------------------------------------------
for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  for($j=1; $j<=$numOfFollow; $j++)
  {
    //add the follwing to user's followings
    $connRedis->zadd("followingsTEMP:0", $timestamp,1);
    $connRedis->HINCRBY("userTEMP:0","following",1);
    //get the followings' tweets
    $allTweets = $connRedis-> ZREVRANGEBYSCORE("homeTEMP:1","+inf","-inf");
    foreach ($allTweets as $tweetId)
     {
       if($connRedis->hget("tweetTEMP:".$tweetId,"userId")==1)
       {
         $tweetpostedDate = $connRedis->hget("tweetTEMP:".$tweetId,"postedDate");
         $timestamp = substr($tweetpostedDate,0,4).substr($tweetpostedDate,5,2).
         substr($tweetpostedDate,8,2).substr($tweetpostedDate,11,2).
         substr($tweetpostedDate,14,2).substr($tweetpostedDate,17,2);
         $connRedis->zadd("homeTEMP:0",$timestamp,$tweetId);
       }
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
