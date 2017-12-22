<?php
include 'connectdb.php';
//------------------------------------------------------------------------------
$firstName = "Fatemeh";
$lastName = "Shafiee";
$res=0;
echo "Seacrh for a user"."<br>";


for ($i=1; $i<=5; $i++)
{
   $start=microtime(TRUE);//START
    $sql = "SELECT firstName, lastname FROM users
            WHERE firstName=".$firstName. "OR lastName=".$lastName;
    $connDB->query($sql);

  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Iteration ".$i." : ".$timeNeeded."<br>";
  $res= $res + $timeNeeded;
}
$res = $res/5;
echo "Average time for the query : ".  round($res,7). " microseconds"."<br>"."<br>";//END
?>
