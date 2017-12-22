<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "twittertemp";

$connDB = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connDB->connect_error) {
   die("Connection to database failed: " . $connDB->connect_error);
}
//------------------------------------------------------------------------------
$numOfUnFollow=10000;
$res=0;
echo "Number of unfollow : ".$numOfUnFollow."<br>";

for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  for($j=1; $j<=$numOfUnFollow; $j++)
  {
    $sql = "DELETE FROM Follow
            WHERE userId1=1 AND userId2=0";
    $connDB->query($sql);
  }

  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Iteration ".$i." : ".$timeNeeded."<br>";
  $res= $res + $timeNeeded;
}
$res = $res/5;
echo "Average time for the query : ".  round($res,7). " microseconds"."<br>"."<br>";//END

?>
