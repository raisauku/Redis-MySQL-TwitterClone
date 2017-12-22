<?php
include 'connectRedis.php';
//------------------------------------------------------------------------------
echo "Find a user's followers who started following the user after his/her (user's) first tweet : "."<br>";
$userId=10000002;
$res=0;
$currentTime=date("d-m-Y H:i:s");
$min = substr($currentTime,6,4).substr($currentTime,0,2).
substr($currentTime,3,2).substr($currentTime,11,2).
substr($currentTime,14,2).substr($currentTime,17,2);
$min_float=(float)$min;
$score=$min;
$score_float=$min_float;
//echo $min."<br>";
//echo $min_float."<br>";

for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  $AlltweetIds = $connRedis->SMEMBERS("AllTweets:".$userId);
  foreach ($AlltweetIds as $tweetId)//find the date of first tweet
  {
      $tweetPostedDate = $connRedis->hget("tweet:".$tweetId,"postedDate");
      //echo $tweetPostedDate."<br>";
      if ($tweetPostedDate!="0")
      {
        $score = substr($tweetPostedDate,0,4).substr($tweetPostedDate,5,2).
        substr($tweetPostedDate,8,2).substr($tweetPostedDate,11,2).
        substr($tweetPostedDate,14,2).substr($tweetPostedDate,17,2);
        //echo $score."<br>";
        $score_float=(float)$score;
        //echo $score_float."<br>";
        if ( $score_float < $min_float )
        {
          $min_float=$score_float;
          //echo "min_float:".$min_float."<br>";
        }
        //echo $tweetId."<br>";
      }
    }
    $followingUserId = $connRedis->ZREVRANGEBYSCORE("followers:".$userId,$min,$min_float);//return the follower
    //foreach ($followingUserId as $tweetId)//find the date of first tweet
  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Iteration ".$i." : ".$timeNeeded."<br>";
  $res= $res + $timeNeeded;
}
$res = $res/5;
echo "Average time for the query : ".  round($res,7). " microseconds"."<br>"."<br>";//END
?>
