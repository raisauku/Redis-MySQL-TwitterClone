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
$firstname="Test";
$lastname="Test";
$email="Test";
$password="Test";
$gender="Test";
$country="Iran";
$countryId=1;

$numOfRegistered=1;
$res=0;

echo "Number of registered users : ".$numOfRegistered."<br>";

for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  for($j=1; $j<=$numOfRegistered; $j++)
  {
    $sql = "SELECT countryId FROM country WHERE countryName=".$country;
    $connDB->query($sql);
    $sql = "INSERT INTO Users (firstName, lastName, email, password,gender,countryId,signupDate)
    VALUES ('".$firstname."', '".$lastname."', '".$email."', '".$password."', '".$gender."', '".$countryId."', CURRENT_TIMESTAMP)";
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
