<?php
/*  Registers the user */

session_start();
include 'connectdb.php';

$firstname = mysqli_real_escape_string($connDB, $_POST["fn"]);
$lastname = mysqli_real_escape_string($connDB, $_POST["ln"]);
$email = mysqli_real_escape_string($connDB, $_POST["email"]);
$password = mysqli_real_escape_string($connDB, $_POST["password"]);

if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)) {
  $sql = "INSERT INTO Users (firstName, lastName, email, password)
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
  }
} else {
  echo "Error: Please fill the fields correctly";
}
$connDB->close();
?>
