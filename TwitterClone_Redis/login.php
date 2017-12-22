<?php

/*User Login
* Redirect to user profile page
*/
session_start();
include 'connectDB.php';

$errors=array();
function display_errors($errors){
	$display='<ul class="bg-danger">';
	foreach($errors as $error){
		$display.='<li class="text-danger">'.$error.'</li>';
	}
	$display.='</ul>';
	return $display;
}

if($_POST){

	//$email = mysqli_real_escape_string($connDB, $_POST["email"]);
  //$password = mysqli_real_escape_string($connDB, $_POST["password"]);


	//**Fatemeh**
	$email = $_POST["email"];
	$password = $_POST["password"];
	//echo $email;
	$userId = $connDB->get("userEmail:".$email);
	//echo $userId;
	//**Fatemeh**



//form validation
if(empty($email) || empty($password)){
	$errors[]='You must provide the email and password';
}
//Validate email
if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
	$errors[]='Please type a valid email address.';
}

//check if email exist in database
/*$sql=$connDB->query("SELECT * FROM users WHERE email='$email'");
$user=mysqli_fetch_assoc($sql);
$userCount=mysqli_num_rows($sql);
if($userCount<1){
	$errors[]="That email doesn't exist in our database";
}

//password check
$sql=$connDB->query("SELECT * FROM users WHERE email='$email'");
$user=mysqli_fetch_assoc($sql);
$userCount=mysqli_num_rows($sql);
if($user['password'] != $password){

	$errors[]="The password is wrong. Please try again";
}*/



//**Fatemeh**
$resUserEmail = $connDB->hget("user:".$userId,"email");
if ($resUserEmail == Null)
{
	$errors[]="That email doesn't exist in our database";
}
else if ($resUserEmail != Null)
{
	$resUserPass = $connDB->hget("user:".$userId,"password");
	if ($resUserPass != $password)
	{
		$errors[]="The password is wrong. Please try again";
	}
}
//**Fatemeh**


//check for errors
if(!empty($errors)){
		echo display_errors($errors);
}
/*else{
	//log user in and redirect to profile

	$sql =$connDB->query( "SELECT userId, firstName, lastName
					 FROM Users
					 WHERE email='".$email."' AND password='".$password."'");

	if ($sql->num_rows > 0) {
		//Login user
		$row = $sql->fetch_assoc();
		$_SESSION["userId"] = $row["userId"];
		$_SESSION["name"] = $row["firstName"] . " " . $row["lastName"];
		$_SESSION["firstname"] = $row["firstName"];
		//Redirect
		header("Location: userProfile.php?id=" . $row["userId"]);

}
}*/


//**Fatemeh**
else
{//log user in and redirect to profile
	$resUserFirstName =$connDB->hget("user:".$userId,"firstName");
	$resUserLastName = $connDB->hget("user:".$userId,"lastName");
	$_SESSION["userId"] = $userId;
	$_SESSION["name"] = $resUserFirstName . " " . $resUserLastName;
	$_SESSION["firstname"] = $resUserFirstName;
	//Redirect
	header("Location: userProfile.php?id=" . $userId);
}


//**Fatemeh**

}

$connDB->close();
?>
