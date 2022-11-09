<?php
// connection to databse
@include 'Templates/config.php';

// start user session
session_start();

// fetching the value for the user id
$user_id = $_SESSION['user_id'];

// _____________________________________________________________________________

// if user id is not set, then:
if(!isset($user_id)){
  // redirect user to log in again
   header('location:login.php');
};
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
  </head>
  <body>
    <?php include 'Templates/notification.php' ?>
    <?php include 'Templates/navbar.php' ?>


    <?php include 'Templates/footer.php' ?>
  </body>
</html>
