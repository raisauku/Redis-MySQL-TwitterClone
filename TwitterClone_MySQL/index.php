<?php
/* login and Registration Form  */
 session_start();
 include ('connectdb.php');
 include ('includes/head.php');
 include ('includes/navigation.php');

 if(isset($_SESSION["userId"])) {
   header("Location: userProfile.php?id=" . $_SESSION["userId"]);
 }
 ?>
<style>
body{
	background-image:url('images/headerlogo/background5.jpg');
	background-size:100vw 100vh;
	}
</style>

<!-- Main Content -->

<!-- Login Form -->
		<div class="col-md-5">
<div class="row">
	<form class="form2" action="login.php" method="post" style="width:500px; margin-top:150px">
		<div class="form-group">
      <fieldset>
        <legend>Login:</legend>
        Email:<br>
        <input type="text" name="email" value="">
        <br>
        Password:<br>
        <input type="password" name="password" value="">
        <br><br>
        <input type="submit" value="Log in">
      </fieldset>
		</div>
	</form>
</div>
</div>

<!-- Registration Form -->
<div class="col-md-7">
	<div class="row">
  <form class="form2" action="register.php" method="post" style="width: 500px">
   <div >
  <fieldset>
    <legend>Register:</legend>
    First name:<br>
    <input type="text" name="fn" value="">
    <br>
    Last name:<br>
    <input type="text" name="ln" value="">
    <br>
    Email:<br>
    <input type="text" name="email" value="">
    <br>
    Password:<br>
    <input type="password" name="password" value="">
    <br><br>
  </div>
    <input type="submit" value="Register" >
  </fieldset>
</form>
			</div>
		</div>

<?php include "includes/footer.php";?>
