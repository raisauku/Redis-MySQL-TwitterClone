<?php
//MySQL connection--------------------------------------------------------------------------
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "twitter";
 $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}
//Redis Connection------------------------------------------------------------------------------
//Connecting to Redis server on localhost
   $redis = new Redis();
   $redis->connect('127.0.0.1', 6379);
   //echo "Connection to redis server sucessfully"."<br>";
   //check whether server is running or not
   //echo "redis Server is running: ".$redis->ping();
   $cntUser = 1; //count number of Users
   ini_set('max_execution_time', 86400);// 24 hours
//Read data from user table--------------------------------------------------------------------
$sqlUser = "SELECT * FROM users";
$resUser = $conn->query($sqlUser);
if ($resUser->num_rows > 0)
{
  //Access to a row in user table----------------------------------------------------
  while($rowUser = $resUser->fetch_assoc())
  {
    //Redis------------------------------------------

     if ($rowUser["userId"]==10000002)//Raisa's profile
    {
      $redis->Zadd("home:".$rowUser["userId"], "tweetId", $rowUser["userId"]);
      $redis->Zadd("home:".$rowUser["userId"], "signupDate", $rowUser["signupDate"]);
    }
    else//for other users
    {
      $redis->Zadd("home:".$rowUser["userId"], "tweetId", $rowUser["userId"]);
      $redis->Zadd("home:".$rowUser["userId"], "signupDate", $rowUser["signupDate"]);
    }
    //Redis-----------------------------------------------------
  }//while($rowSelFromUser = $resultSelFromUser->fetch_assoc())
}//if ($resultSelFromUser->num_rows > 0)
