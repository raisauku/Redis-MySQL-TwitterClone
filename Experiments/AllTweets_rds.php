<?php
include 'connectRedis.php';

echo "Number of tweets : 928222"."<br>";
$userid=0;//Me with 1 000 000 followers
$res=0;
for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  $connRedis->SCARD("allTweets");

  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Iteration ".$i." : ".$timeNeeded."<br>";
  $res= $res + $timeNeeded;
}
$res = $res/5;
echo "Average time for the query : ".  round($res,7). " microseconds"."<br>"."<br>";//END

?>
