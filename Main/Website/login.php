<?php
// connection to database
@include 'Templates/config.php';
include 'Templates/HackingDetectedTemp.php';

// start user session
if (isset($_SESSION)){
  // If Session is Set Regenerate a new ID
  session_regenerate_id();
}else{
  // Start Session
  session_start();
}
// Include Composer Libraries
include_once(__DIR__.'/vendor/autoload.php');
// Use Goofle 2 factor Authentication Library
use PragmaRX\Google2FA;

// _____________________________________________________________________________

// if the submit(login) button is pressed,
if(isset($_POST['submit'])){
  // These two functions are important for extra security purpose in the signup form:
  // The FILTER_SANITIZE_STRING filter removes tags and remove or encode special characters from a string.
  // mysqli_real_escape_string() function escapes special characters in a string and prevents against sql attacks

  // fetch the email & password of the user
   $email = mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_STRING));
   $pass = mysqli_real_escape_string($conn, md5(filter_var($_POST['password'], FILTER_SANITIZE_STRING)));


// _____________________________________________________________________________

   // select all users that have the same email and password that the user just entered from the users table in the databse, if possible
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');


   // if the rows returned are more than 0, then:
   if(mysqli_num_rows($select_users) > 0){
     // Return an associative array of the user's data
      $row = mysqli_fetch_assoc($select_users);
      // Store User ID
      $uid = $row['UserID'];
      // Failed Login Counter
      $FailedLogin = $row['FailedLogin'];
// _____________________________________________________________________________

      // Set CSRF Token
      $_SESSION["csrf"] = bin2hex(random_bytes(32));
      $_SESSION["csrf-expire"] = time() + 3600; // 1 hour = 3600 secs
// _____________________________________________________________________________

      // Set Session Attributes for Authentication
      $_SESSION['user_name'] = $row['name'];
      $_SESSION['user_email'] = $row['email'];
      $_SESSION['UID'] = $uid;

      // Check if Failed login attempts exceeded Limits
      if ($FailedLogin > 2)
      {
        // Send an Alert to the security team.
        $msg = $FailedLogin . " Failed Login Attempts Were Captured On The Account " . $row['email'];
        Hacking_Detected($msg,$uid,$msg,"Login",1);
      }else
      {
        // Check if User does not has a QR code
        if ($row['QR'] == 0){
          // Create a new Google 2FA Object
          $google2fa = new \PragmaRX\Google2FA\Google2FA();
          // Generate User Token
          $secret = $google2fa->generateSecretKey();

          // Store User token in DB
          mysqli_query($conn, "UPDATE `users` SET  2fa = '$secret'  WHERE UserID = '$uid'") or die('query failed');
        }
        // Set User Failed Logins to 0 on login
        mysqli_query($conn, "UPDATE `users` SET  FailedLogin = 0  WHERE UserID = '$uid'") or die('query failed');
        // Go to the Setup 2FA page
        header('location:Setup_2fa.php');
      }

    }else{
       // if email or password do not match the ones stored in the users table in the database
       // Get the User by email if found
      $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');


      if(mysqli_num_rows($select_users) > 0){
        // Return an associative array of the user's data
         $row = mysqli_fetch_assoc($select_users);
         // Store User ID
         $uid = $row['UserID'];
         // Increment Failed Login Counter by 1
         $FailedLogin = $row['FailedLogin'] + 1;

         //Update the Failed Login Counter
         mysqli_query($conn, "UPDATE `users` SET FailedLogin = $FailedLogin  WHERE UserID = '$uid'") or die('query failed');
       }
      $message[] = 'Incorrect email or password, try again!'; // store notification message
    }
}
// _____________________________________________________________________________
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Metadata -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Style sheet -->
  <link rel="stylesheet" href="CSS/login.css">
  <!-- Title -->
  <title>Login Page</title>
</head>
<body>
  <!-- Notifications -->
  <?php include 'Templates/notification.php' ?>

 <!-- Login Form  -->
  <div class="login-wrapper">
    <form action="login.php" method="POST" class="form">
      <img class="AvatarIcon" src="images/avatar.png" alt="">
      <!-- Title -->
      <h2>Login</h2>
      <!-- Email Input Field -->
      <div class="input-group">
        <input type="email" name="email" id="loginUser" required>
        <label for="email">Email</label>
      </div>
      <!-- Password Input Field -->
      <div class="input-group">
        <input type="password" name="password" id="loginPassword" required>
        <label for="password">Password</label>
      </div>
      <!-- Submit Button -->
      <input type="submit" name="submit" value="Login" class="submit-btn">
      <!-- Sign up Prompt -->
      <span class="mssg">New Here? <a href="signup.php">Sign Up</a> </span>
      <br><br>
      <!-- Forget password Prompt -->
      <span class="mssg"><a href="resetPasswordAccount.php">Forgot Password?</a> </span>
    </form>
  </div>
</body>?
</html>
