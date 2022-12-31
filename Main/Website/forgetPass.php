<?php

include 'Templates/config.php';

session_start();

// prevent session hijacking
@include 'Templates/session_hijacking_prevention.php';

include 'Templates/PasswordPolicy.php';

if(isset($_POST['submit'])){
  // These two functions are important for extra security purpose in the signup form:
  // The FILTER_SANITIZE_STRING filter removes tags and remove or encode special characters from a string.
  // mysqli_real_escape_string() function escapes special characters in a string and prevents against sql attacks
  // passwords md5 hashing for an extra layer of security for the users

  // fetch the  email, password & confirm password of the user
   $email = $_SESSION["Vemail"];
   $PasswordIsCompliant = PasswordComply(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
   $pass = mysqli_real_escape_string($conn, md5(filter_var($_POST['password'], FILTER_SANITIZE_STRING)));
   $cpass = mysqli_real_escape_string($conn, md5(filter_var($_POST['confirmPassword'], FILTER_SANITIZE_STRING)));

 // _____________________________________________________________________________

    // select all users that have the same email that the user just entered from the users table in the database, if possible
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    // if the rows returned are more than 0, that means that this email was used already
    if(mysqli_num_rows($select_users) > 0){
      // if the 2 paaswords entered do not match
       if($pass != $cpass){
          $message[] = 'Passwords do not match!'; // store notification message
// _____________________________________________________________________________
       }else{

         if ($PasswordIsCompliant)
         {

         // if all input was valid, insert these values into the users table in the databsae
            mysqli_query($conn, "UPDATE `users` SET password = '$pass' WHERE email = '$email'") or die('query failed');
            $message[] = 'Password changed successfully!'; // store notification message
            // redirect user to the login page
            header('location:login.php');
          }else
          {
            $message[] = "Password Doesnt Comply with Password Policy";
          }
       }

       }else{
         $message[] = 'User doesn\'t exist!'; // store notification message
       }
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="CSS/login.css">
  <title>Forgot Password</title>
</head>
<body>

  <?php include 'Templates/notification.php' ?>

  <div class="login-wrapper">
    <form action="forgetPass.php" method="POST" class="form">
      <img class="AvatarIcon" src="images/avatar.png" alt="">
      <h2>Change Password</h2>

      <div class="input-group">
        <input type="password" name="password" id="loginPassword" required>
        <label for="loginpassword">Password</label>
      </div>
      <div class="input-group">
        <input type="password" name="confirmPassword" id="loginCPassword" required>
        <label for="loginCPassword">Confirm Password</label>
      </div>
      <input type="submit" name="submit" value="Submit" class="submit-btn">

    </form>
  </div>
</body>?
</html>
