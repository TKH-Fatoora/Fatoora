<?php
// connection to database
@include 'Templates/config.php';

// start  session
session_start();
// regenerating a session id
session_regenerate_id();
// free all session variables
session_unset();
// close session
session_destroy();
//session_write_close();

// redirect user to log in again
header('location:login.php');


?>
