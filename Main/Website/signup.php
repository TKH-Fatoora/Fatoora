<?php
// Database Configuration File
include 'Templates/config.php';

//Start Session
session_start();

// Password Policy Include
include 'Templates/PasswordPolicy.php';

// On Form Submisssion
if(isset($_POST['submit'])){
  // These two functions are important for extra security purpose in the signup form:
  // The FILTER_SANITIZE_STRING filter removes tags and remove or encode special characters from a string.
  // mysqli_real_escape_string() function escapes special characters in a string and prevents against sql attacks
  // passwords md5 hashing for an extra layer of security for the users

  // fetch the username, email,date of birth, password & confirm password of the user
   $name = mysqli_real_escape_string($conn, filter_var($_POST['name'], FILTER_SANITIZE_STRING));
   $email = mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_STRING));

   //Check if password Complies with Password Policy
   $PasswordIsCompliant = PasswordComply(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
   $pass = mysqli_real_escape_string($conn, md5(filter_var($_POST['password'], FILTER_SANITIZE_STRING)));
   $cpass = mysqli_real_escape_string($conn, md5(filter_var($_POST['confirmPassword'], FILTER_SANITIZE_STRING)));
   $dob = mysqli_real_escape_string($conn, $_POST['DOB']);

 // _____________________________________________________________________________

    // select all users that have the same email that the user just entered from the users table in the database, if possible
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    // if the rows returned are more than 0, that means that this email was used already
    if(mysqli_num_rows($select_users) > 0){
          $message[] = 'User already exists!'; // store notification message
       }else{
         // if the 2 paaswords entered do not match
          if($pass != $cpass){
             $message[] = 'Passwords do not match!'; // store notification message
 // _____________________________________________________________________________
          }else{
            //Password Policy
            if ($PasswordIsCompliant)
            {
            // if all input was valid, insert these values into the users table in the databsae
             mysqli_query($conn, "INSERT INTO `users`(name, email, password, birthdate) VALUES('$name', '$email', '$pass', '$dob')") or die('query failed');
             $message[] = 'Registered successfully!'; // store notification message
             // redirect user to the login page
             $_SESSION["Vemail"] = $email;
             // Set Verification Purpose
             $_SESSION["VPurpose"] = "signup";
             // Go to Verification Page
             header('location:Verify.php');
           }else
           {
             $message[] = "Password Doesnt Comply with Password Policy"; // store notification message
           }
          }
       }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Meta Data -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Stylesheet -->
  <link rel="stylesheet" href="CSS/sign-up.css">
  <!-- Title -->
  <title>Sign Up</title>
</head>
<body>
  <!-- Notifications -->
  <?php include 'Templates/notification.php' ?>

  <!-- Sign Up Form  -->
  <div class="login-wrapper">
    <form action="signup.php" method='post' class="form">
      <img src="images/avatar.png" alt="">
      <!-- Title -->
      <h2>Sign-Up</h2>
      <!-- Name Input Field -->
      <div class="input-group">
        <input type="text" name="name" id="loginUser" required>
        <label for="loginUser">Name</label>
      </div>
      <!-- Email Input Field -->
      <div class="input-group">
        <input type="email" name="email" id="loginEmail" required>
        <label for="loginEmail">Email</label>
      </div>
      <!-- Password Input Field -->
      <div class="input-group">
        <input type="password" name="password" id="loginPassword" required>
        <label for="loginPassword">Password</label>
      </div>
      <!-- Confirm Password Input Field -->
      <div class="input-group">
        <input type="password" name="confirmPassword" id="loginCPassword" required>
        <label for="loginCPassword">Confirm Password</label>
      </div>
      <!-- Date Of Birth Password Input Field -->
      <div class="input-group">
        <input type="date" name="DOB" id="loginDOB" required>
        <label for="loginDOB">Date of Birth</label>
      </div>
      <!-- Submit Button -->
      <input type="submit" name="submit" value="Sign Up" class="submit-btn">
      <br>
      <!-- Login Propmt -->
      <span class="mssg">Already Have an account? <a href="login.php">Log In</a> </span>
    </form>
  </div>
</body>
</html>
