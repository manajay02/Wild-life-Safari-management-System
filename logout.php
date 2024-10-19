<?php
session_start();

// Destroy all session data
session_unset(); 
session_destroy(); 

// Redirect to login page or home page after logout
header("Location: login.php");
exit();
?>
