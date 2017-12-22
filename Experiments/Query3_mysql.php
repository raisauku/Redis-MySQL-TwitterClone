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
$country="Belgium";
$res=0;


for ($i=1; $i<=5; $i++)
{
  $start=microtime(TRUE);//START

  $sql="UPDATE users
  SET users.countryId = (select country.countryId from country
  WHERE country.countryName = '".$country."')
  where users.userId in (
  SELECT DISTINCT u1.userId
  FROM
  (SELECT users.userId  FROM Users
          JOIN Follow ON Users.userId=Follow.userId2
          group by follow.userId1
          having (count(*)>10)
          ) u1
   INNER JOIN (Select Users.userId  FROM Users
          JOIN Follow ON Users.userId=Follow.userId1
         group by follow.userId2
          having (count(*)>10)
          )  u2
  ON  u2.userId)";

  $connDB->query($sql);

  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Iteration ".$i." : ".$timeNeeded."<br>";
  $res= $res + $timeNeeded;
}
$res = $res/5;
echo "Average time for the query : ".  round($res,7). " microseconds"."<br>"."<br>";//END

?>
