<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "twitter";

$connDB = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connDB->connect_error) {
   die("Connection to database failed: " . $connDB->connect_error);
}
//------------------------------------------------------------------------------
$userid=0;
$res=0;


for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START
  $sql=" SELECT * FROM Users
        JOIN Follow ON Users.userId=Follow.userId1
         WHERE userId2=".$userid."
         AND followingDate > (SELECT MIN(postedDate) from Tweets JOIN Users ON Users.userId= Tweets.userId AND Users.userId=".$userid.")";
  $connDB->query($sql);

  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Iteration ".$i." : ".$timeNeeded."<br>";
  $res= $res + $timeNeeded;
}
$res = $res/5;
echo "Average time for the query : ".  round($res,7). " microseconds"."<br>"."<br>";//END

?>
