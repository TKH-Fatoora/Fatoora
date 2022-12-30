<?php
// connection to database
@include 'Templates/config.php';

// start user session
if (isset($_SESSION)){
  session_regenerate_id();
}else{
  session_start();
}

include_once(__DIR__.'/vendor/autoload.php');
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


   $google2fa = new \PragmaRX\Google2FA\Google2FA();
   $secret = $google2fa->generateSecretKey();


// _____________________________________________________________________________

   // select all users that have the same email and password that the user just entered from the users table in the databse, if possible
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');


   // if the rows returned are more than 0, then:
   if(mysqli_num_rows($select_users) > 0){
     // Return an associative array of the user's data
      $row = mysqli_fetch_assoc($select_users);
      $uid = $row['UserID'];

// _____________________________________________________________________________
      // $cookie_name = "uid";
      // $cookie_value = md5($uid);
      //
      // setcookie($cookie_name, $cookie_value, time() + (86400), "/"); // 86400 = 1 day
// _____________________________________________________________________________
      $_SESSION["token"] = bin2hex(random_bytes(32));
      $_SESSION["token-expire"] = time() + 3600; // 1 hour = 3600 secs
// _____________________________________________________________________________

      $_SESSION['user_name'] = $row['name'];
      $_SESSION['user_email'] = $row['email'];
      $_SESSION['UID'] = $uid;


      if ($row['QR'] == 0){
        $google2fa = new \PragmaRX\Google2FA\Google2FA();
        $secret = $google2fa->generateSecretKey();

        mysqli_query($conn, "UPDATE `users` SET 2fa = '$secret'  WHERE UserID = '$uid'") or die('query failed');
      }
      header('location:Setup_2fa.php');

    }else{ // if email or password do not match the ones stored in the users table in the database
      $message[] = 'Incorrect email or password, try again!'; // store notification message
    }
}
// _____________________________________________________________________________
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="CSS/login.css">
  <title>Login Page</title>
</head>
<body>

  <?php include 'Templates/notification.php' ?>

  <div class="login-wrapper">
    <form action="login.php" method="POST" class="form">
      <img class="AvatarIcon" src="images/avatar.png" alt="">
      <h2>Login</h2>
      <div class="input-group">
        <input type="email" name="email" id="loginUser" required>
        <label for="email">Email</label>
      </div>
      <div class="input-group">
        <input type="password" name="password" id="loginPassword" required>
        <label for="password">Password</label>
      </div>
      <input type="submit" name="submit" value="Login" class="submit-btn">
      <span class="mssg">New Here? <a href="signup.php">Sign Up</a> </span>
      <br><br>
      <span class="mssg"><a href="resetPasswordAccount.php">Forgot Password?</a> </span>
    </form>
  </div>
</body>?
</html>
