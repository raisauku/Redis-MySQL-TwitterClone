<?php
include 'connectRedis.php';
//------------------------------------------------------------------------------
echo "Find tweets including a word that are posted from 2003 to 2010 ".
"by users who joined twitter in 2000 : "."<br>";
$keyword="what";
$startTime=20030101000101;
$endTime=20100101000101;
$signDate1=20000101000101;
$signDate2=20001231235959;
$flag="No";
$res=0;


for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  $AlltweetIds = $connRedis->SMEMBERS("words:".$keyword);
  foreach ($AlltweetIds as $tweetId)//find the date of first tweet
  {
    $result= $connRedis->hget("tweet:".$tweetId,"userId","postedDate");
    $postedDate = substr($result["postedDate"],0,4).substr($result["postedDate"],5,2).
    substr($result["postedDate"],8,2).substr($result["postedDate"],11,2).
    substr($result["postedDate"],14,2).substr($result["postedDate"],17,2);
    $postedDate_float=(float)$postedDate;

    if (($postedDate >= $startTime) && ($postedDate <= $endTime))
    {
      $result2= $connRedis->hget("user:".$result["userId"],"signupDate");
      $signupDate = substr($result2["signupDate"],0,4).substr($result2["signupDate"],5,2).
      substr($result2["signupDate"],8,2).substr($result2["signupDate"],11,2).
      substr($result2["signupDate"],14,2).substr($result2["signupDate"],17,2);
      $signupDate_float=(float)$signupDate;
      if (($signupDate >= $signDate1) && ($signupDate <= $signDate2))
      {
        $flag="Yes";
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
