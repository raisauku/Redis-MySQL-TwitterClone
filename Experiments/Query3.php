<?php
include 'connectRedis.php';
//------------------------------------------------------------------------------
echo "update the male users' countries to Belgium who has more than 1 followers and 1 followings : "."<br>";
$res=0;
$gender="M";
$country="Iran";
$NumOfFollowers=1;
$NumOfFollowings=1;

for ($i=1; $i<=1; $i++)
{
  $start=microtime(TRUE);//START

  $allUsers= $connRedis->SMEMBERS("allUsers");
  foreach ($allUsers as $userId)//find the date of first tweet
  {
    //echo $userId."<br>";
    $UserGender= $connRedis->hget("user:".$userId,"gender");
    //echo $UserGender."<br>";
    if ($UserGender == $gender )
    {
      $followings= $connRedis->ZCOUNT("followings:".$userId,"-inf","+inf");
      //echo $followings."<br>";
      if ($followings>$NumOfFollowings)
      {
        $followers= $connRedis->ZCOUNT("followers:".$userId,"-inf","+inf");
        //echo $followers."<br>";
        if ($followers>$NumOfFollowers)
        {
          $connRedis->hset("user:".$userId,"country",$country );
          //echo "DONE!"."<br>";
        }
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
