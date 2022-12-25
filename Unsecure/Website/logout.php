<?php
// connection to database
@include 'Templates/config.php';

// start  session
session_start();
// free all session variables
session_unset();
// close session
session_destroy();

// redirect user to log in again
header('location:login.php');

?>
