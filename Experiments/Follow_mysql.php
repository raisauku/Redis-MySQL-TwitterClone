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
$numOfFollow=10000;
$res=0;
echo "Number of follow : ".$numOfFollow."<br>";

for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  for($j=1; $j<=$numOfFollow; $j++)
  {
    $sql = "INSERT INTO Follow (userId1, userId2, followingDate)
            VALUES (1, 0, CURRENT_TIMESTAMP)";
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
