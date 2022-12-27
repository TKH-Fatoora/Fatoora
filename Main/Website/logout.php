<?php
// connection to database
@include 'Templates/config.php';

// start  session
session_start();

// $cookie_name = "uid";
// try {
//   $cookie_value = md5($_SESSION['admin_id']);
// } catch (\Exception $e) {
//   $cookie_value = md5($_SESSION['user_id']);
// } finally{
//   $cookie_value = md5($_SESSION['employee_id']);
// }
// setcookie($cookie_name, "", time() - 86400, "/");
// unset($_COOKIE["uid"]);

// unset cookies
// if (isset($_COOKIE["uid"])) {
//     $cookies = explode(';', $_COOKIE["uid"]);
//     foreach($cookies as $cookie) {
//         $parts = explode('=', $cookie);
//         $name = trim($parts[0]);
//         setcookie($name, '', time()-1000);
//         setcookie($name, '', time()-1000, '/');
//     }
// }

session_regenerate_id();
// free all session variables
session_unset();
// close session
session_destroy();

//session_write_close();

// redirect user to log in again
header('location:login.php');


?>
