<?php
// Databsase connection Configuration
include 'Templates/config.php';

// Start Session
session_start();

// prevent session hijacking
@include 'Templates/session_hijacking_prevention.php';

// Password Policy Template
include 'Templates/PasswordPolicy.php';

// _____________________________________________________________________________

// When Form Submits Back
if(isset($_POST['Back'])){
  // Go Back to Login Page
  header('location:login.php');
}
// _____________________________________________________________________________

if(isset($_POST['submit'])){
  // These two functions are important for extra security purpose in the signup form:
  // The FILTER_SANITIZE_STRING filter removes tags and remove or encode special characters from a string.
  // mysqli_real_escape_string() function escapes special characters in a string and prevents against sql attacks
  // passwords md5 hashing for an extra layer of security for the users

  // fetch the Verification email of the user
   $email = $_SESSION["Vemail"];
   // Check if Password Coomplies with the Password Policy
   $PasswordIsCompliant = PasswordComply(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
   // Filter , Hash and Store Password and the Confirm Password
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
        }
// _____________________________________________________________________________
       else{
         // Check if Password Complies
         if ($PasswordIsCompliant)
         {
            // If Password Does Comply

            //Checl if all input was valid, insert these values into the users table in the databsae
            mysqli_query($conn, "UPDATE `users` SET password = '$pass' WHERE email = '$email'") or die('query failed');
            $message[] = 'Password changed successfully!'; // store notification message

            // redirect user to the login page
            header('location:logout.php');
          }else
          {
            // if Password Does Not Comply
            $message[] = "Password Doesnt Comply with Password Policy"; // store notification message
          }
       }

       }else{
         // If No Users Exist with the Email and Password Pair
         $message[] = 'User doesn\'t exist!'; // store notification message
       }
 }
 // _____________________________________________________________________________
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Meta Data -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Stylesheet -->
  <link rel="stylesheet" href="CSS/login.css">
  <!-- Title  -->
  <title>Forgot Password</title>
</head>
<body>
  <!-- Notifications -->
  <?php include 'Templates/notification.php' ?>

  <!-- Forget Password Form -->
  <div class="login-wrapper">
    <form action="forgetPass.php" method="POST" class="form">
      <img class="AvatarIcon" src="images/avatar.png" alt="">
      <!-- Form title -->
      <h2>Change Password</h2>
      <!-- New Password Input Field  -->
      <div class="input-group">
        <input type="password" name="password" id="loginPassword" required>
        <label for="loginpassword">Password</label>
      </div>

      <!-- Confirm Password Input Field -->
      <div class="input-group">
        <input type="password" name="confirmPassword" id="loginCPassword" required>
        <label for="loginCPassword">Confirm Password</label>
      </div>
      <!-- Buttons Div -->
      <div class="Buttons">
        <input type="submit" name="Back" value="Back" class="back-btn">
        <input type="submit" name="Next" value="Next" class="submit-btn">
      </div>
    </form>
  </div>
</body>?
</html>
