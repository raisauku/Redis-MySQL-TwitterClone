<?php
include 'connectRedis.php';
//------------------------------------------------------------------------------
$tweetSrc = "What";
$res=0;
echo "Seacrh for tweets including the word : ".$tweetSrc."<br>";


for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  $allTweetId = $connRedis->smembers("word:".$tweetSrc);
  /*foreach ($allTweetId as $tweetId)
  {
    $tweetText = $connRedis->hget("tweet:".$tweetId,"tweetText");
  }*/

  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Iteration ".$i." : ".$timeNeeded."<br>";
  $res= $res + $timeNeeded;
}
$res = $res/5;
echo "Average time for the query : ".  round($res,7). " microseconds"."<br>"."<br>";//END
?>
