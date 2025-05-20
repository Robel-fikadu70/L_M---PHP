<?php
session_start();


session_unset(); // Unsets all session variables
session_destroy();

// Redirect the user to the login page
header("Location: homepage.php");
exit();
?>