<?php
include 'connectRedis.php';

echo "Number of followings : 1000000"."<br>";
$userid=0;//Me with 1 000 000 followers
$res=0;
for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  $connRedis-> Zcard("followings:".$userid);

  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Iteration ".$i." : ".$timeNeeded."<br>";
  $res= $res + $timeNeeded;
}
$res = $res/5;
echo "Average time for the query : ".  round($res,7). " microseconds"."<br>"."<br>";//END
//-------------------------------------------------------------------------------------
echo "Number of followings : 100000"."<br>";
$userid=10000002;//Raisa with 100 000 followers
$res=0;
for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  $connRedis-> Zcard("followings:".$userid);

  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Iteration ".$i." : ".$timeNeeded."<br>";
  $res= $res + $timeNeeded;
}
$res = $res/5;
echo "Average time for the query : ".  round($res,7). " microseconds"."<br>"."<br>";//END
//----------------------------------------------------------------------------------------
echo "Number of followings : 1"."<br>";
$userid=1;//A user with 2 followers
$res=0;
for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  $connRedis-> Zcard("followings:".$userid);

  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Iteration ".$i." : ".$timeNeeded."<br>";
  $res= $res + $timeNeeded;
}
$res = $res/5;
echo "Average time for the query : ".  round($res,7). " microseconds"."<br>"."<br>";//END
?>
