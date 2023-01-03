<?php
// Database Connection Configuration
include 'Templates/config.php';

// Start Session
session_start();


// Setting Session Hijacking Paramters
$_SESSION['ipaddress'] = $_SERVER['REMOTE_ADDR'];       // Storing User Remote Ip Address
$_SESSION['useragent'] = $_SERVER['HTTP_USER_AGENT'];   // Storing the User's Browser Info
$_SESSION['lastaccess'] = time();                       // Storing User Last Access time

// _____________________________________________________________________________

// When Form Submits Back
if(isset($_POST['Back'])){
  // Go Back to Login Page
  header('location:login.php');
}
// _____________________________________________________________________________

// On Submit
if(isset($_POST['Next'])){
  // These two functions are important for extra security purpose in the signup form:
  // The FILTER_SANITIZE_STRING filter removes tags and remove or encode special characters from a string.
  // mysqli_real_escape_string() function escapes special characters in a string and prevents against sql attacks
  // passwords md5 hashing for an extra layer of security for the users

  // fetch the  email of the user
   $email = mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_STRING));

 // _____________________________________________________________________________

    // select the user that have the same email that the user just entered from the users table in the database, if possible
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    // if the rows returned are more than 0, that means that this email is valid
    if(mysqli_num_rows($select_users) > 0){
          // Format Data as Associative Array
          $row = mysqli_fetch_assoc($select_users);
          $uid = $row["UserID"];             // Store User ID
          $name = $row["name"];              // Store User Name
          $vrfy = $row["Verified"];          // Store User Verification State
          $_SESSION["Vemail"] = $email;      // Set Verification Email to user email
          $_SESSION["VPurpose"] = "resetP";  // Set Verification purpose to reset Password

          // redirect user to the Verify page
          header('location:Verify.php');

       }else{
         $message[] = 'User doesn\'t exist!'; // store notification message
       }
 }
// _____________________________________________________________________________
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Metadata -->
  <meta charset="UTF-8">``
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Stylesheet -->
  <link rel="stylesheet" href="CSS/login.css">
  <!-- Title -->
  <title>Forgot Password</title>
</head>
<body>

  <!-- Notifications -->
  <?php include 'Templates/notification.php' ?>

  <!-- Verification Email Form -->
  <div class="login-wrapper">
    <form action="resetPasswordAccount.php" method="POST" class="form">
      <img class="AvatarIcon" src="images/avatar.png" alt="">
      <!-- Form Title -->
      <h2>Change Password</h2>
      <!-- Info Span -->
      <span>Please Specify your email</span>

      <!-- user Email Input Field -->
      <div class="input-group">
        <input type="email" name="email" id="loginUser" required>
        <label for="email">Email</label>
      </div>

      <!-- Button Div -->
      <div class="Buttons">
        <input type="submit" name="Next" value="Next" class="submit-btn">
        <input type="submit" name="Back" value="Back" class="back-btn">
      </div>

    </form>
  </div>
</body>?
</html>
