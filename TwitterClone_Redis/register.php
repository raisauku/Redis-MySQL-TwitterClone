<?php
/*  Registers the user */

session_start();
include 'connectdb.php';

/*$firstname = mysqli_real_escape_string($connDB, $_POST["fn"]);
$lastname = mysqli_real_escape_string($connDB, $_POST["ln"]);
$email = mysqli_real_escape_string($connDB, $_POST["email"]);
$password = mysqli_real_escape_string($connDB, $_POST["password"]);*/

//**Fatemeh**
$firstname = $_POST["fn"];
$lastname =  $_POST["ln"];
$email =  $_POST["email"];
$password =  $_POST["password"];
//**Fatemeh**



if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)) {
/*  $sql = "INSERT INTO Users (firstName, lastName, email, password)
  VALUES ('".$firstname."', '".$lastname."', '".$email."', '".$password."')";
   $result=$connDB->query($sql);
  if ($result === TRUE) {
     // Get the if of the last inserted user by insert_id
      $_SESSION["userId"] = $connDB->insert_id;
      $_SESSION["name"] = $firstname . " " . $lastname;
      $_SESSION["firstname"] = $firstname;
      header("Location: userProfile.php?id=" . $_SESSION["userId"] );
  } else {
      echo "Error: " . $sql . "<br>" . $connDB->error;
  }*/


  //**Fatemeh**
  $userId = $connDB->hget("num", "user");
  $connDB->hincrby("num", "user", 1);
  //echo $userId;
  $userId = $userId +1;
  //create hash user
  $connDB->hset("user:".$userId, "firstName", $firstname);
  $connDB->hset("user:".$userId, "lastName", $lastname);
  $connDB->hset("user:".$userId, "email", $email);
  $connDB->hset("user:".$userId, "password", $password);
  $connDB->hset("user:".$userId, "following", 0);
  $connDB->hset("user:".$userId, "follower", 0);
  $connDB->hset("user:".$userId, "posts", 0);
  $timestamp = date("d-m-Y H:i:s");
  $connDB->hset("user:".$userId, "signupDate", $timestamp);

  //create index user (set)
  $redis->Set("userEmail:".$email, $userId);
  $redis->Zadd("firstName:".$firstname, $userId,$lastname);
  $redis->Zadd("lastName:".$lastname, $userId,$firstname);
  $currenttimestamp = substr($timestamp,6,4).substr($timestamp,0,2).
  substr($timestamp,3,2).substr($timestamp,11,2).
  substr($timestamp,14,2).substr($timestamp,17,2);
  echo $currenttimestamp;
  echo $userId;
  $redis->Zadd("allUsers",$currenttimestamp, $userId);

  $_SESSION["userId"] = $userId;
  $_SESSION["name"] = $firstname . " " . $lastname;
  $_SESSION["firstname"] = $firstname;
  header("Location: userProfile.php?id=" . $_SESSION["userId"] );
  //**Fatemeh**


} else {
  echo "Error: Please fill the fields correctly";
}
$connDB->close();
?>
