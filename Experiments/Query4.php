<?php
include 'connectRedis.php';
//------------------------------------------------------------------------------
echo "Delete users who has not posted any tweets and also their followings and followers have not posted any tweets : "."<br>";
$res=0;


for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  $allUsers= $connRedis->SMEMBERS("allUsers");
  foreach ($allUsers as $userId)//find the date of first tweet
  {
    //echo $userId."<br>";
    $UserHome= $connRedis->zcard("home:".$userId);
    //echo $UserGender."<br>";
    if ($UserHome == 0 )
    {
      //echo $userId;
      $connRedis->SREM("allUsers",$userId);//delete from allUsers
      $UserFisrtName= $connRedis->hget("user:".$userId,"firstName");
      $connRedis->HDEL("firstName:".$UserFisrtName,$userId);//delete from firstName
      $connRedis->del("user:".$userId);
      $connRedis->del("home:".$userId);
      $connRedis->del("followings:".$userId);
      $connRedis->del("followers:".$userId);
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
