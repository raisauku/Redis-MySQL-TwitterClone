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
$searchWord="what";
$res=0;


for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  $sql=" SELECT tweetText FROM tweets
         JOIN users on tweets.userId = users.userId
  WHERE tweetText LIKE '%".$searchWord."%'
  AND (tweets.postedDate BETWEEN '2003-01-01 00:00:00' AND '2010-12-31 23:59:59')
  AND (Users.signupDate  BETWEEN '2000-01-01 00:00:00' AND '2000-12-31 23:59:59')";

  $connDB->query($sql);

  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Iteration ".$i." : ".$timeNeeded."<br>";
  $res= $res + $timeNeeded;
}
$res = $res/5;
echo "Average time for the query : ".  round($res,7). " microseconds"."<br>"."<br>";//END

?>
