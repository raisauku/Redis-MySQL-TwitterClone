<?php
include 'connectRedis.php';

$userId="TEMP";
$firstname="Test";
$lastname="Test";
$email="Test";
$password="Test";
$gender="Test";
$countryId=1;
$timestamp = date("d-m-Y H:i:s");

$numOfRegistered=10000;
$res=0;
echo "Number of registered users : ".$numOfRegistered."<br>";
//---------------------------------------------------------------------------
for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  for($j=1; $j<=$numOfRegistered; $j++)
  {
    $connRedis->hset("user:".$userId, "firstName", $firstname);
    $connRedis->hset("user:".$userId, "lastName", $lastname);
    $connRedis->hset("user:".$userId, "email", $email);
    $connRedis->hset("user:".$userId, "password", $password);
    $connRedis->hset("user:".$userId, "following", 0);
    $connRedis->hset("user:".$userId, "follower", 0);
    $connRedis->hset("user:".$userId, "posts", 0);
    $connRedis->hset("user:".$userId, "signupDate", $timestamp);
    $connRedis->hset("user:".$userId, "countryId", $countryId);
    $connRedis->hset("user:".$userId, "gender", $gender);
  }

  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Iteration ".$i." : ".$timeNeeded."<br>";
  $res= $res + $timeNeeded;
}
$res = $res/5;
echo "Average time for the query : ".  round($res,7). " microseconds"."<br>"."<br>";//END
?>
