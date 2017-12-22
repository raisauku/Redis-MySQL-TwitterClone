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
$tweetText="Hello! This is a test!";
$numOfTweets=10000;
$res=0;
echo "Number of inserted tweets : ".$numOfTweets."<br>";


for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  for($j=1; $j<=$numOfTweets; $j++)
  {
    $sql = "INSERT INTO tweets (userId, tweetText, postedDate)
    VALUES ('".$j."', '" . $tweetText . "', CURRENT_TIMESTAMP)";
    $connDB->query($sql);
    for ($k=1; $k<=7; $k++)
    {
      $sql = "INSERT INTO words (tweetId, word)
      VALUES ('".$j."', 'TEMP')";
      $connDB->query($sql);
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
