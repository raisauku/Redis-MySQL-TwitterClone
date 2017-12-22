<?php
/*  Logout the user  */
session_start();

// remove all session variables and destroy the session
session_unset();
session_destroy(); 

header("Location: index.php");
?>
