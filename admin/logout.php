<?php 
session_start();

setcookie('loggedout', '<h5>Logged out successfully</h5>', time() + 3600, "/");
session_destroy(); 

header("Location: login.php");
exit();
?>
