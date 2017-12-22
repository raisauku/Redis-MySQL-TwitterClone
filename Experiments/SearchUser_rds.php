<?php
include 'connectRedis.php';
//------------------------------------------------------------------------------
$firstName = "Fatemeh";
$lastName = "Shafiee";
$res=0;
echo "Search for a user"."<br>";


for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  $result=$connRedis->Hget("firstName:".$firstName, "lastName");
  $result=$connRedis->Hget("lastName:".$lastName, "firstName");


  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Iteration ".$i." : ".$timeNeeded."<br>";
  $res= $res + $timeNeeded;
}
$res = $res/5;
echo "Average time for the query : ".  round($res,7). " microseconds"."<br>"."<br>";//END
?>
