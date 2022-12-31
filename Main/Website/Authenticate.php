<?php

@include 'Templates/config.php';
include 'Templates/HackingDetectedTemp.php';

include_once(__DIR__.'/vendor/autoload.php');
use PragmaRX\Google2FA;

session_start();
$_SESSION['ipaddress'] = $_SERVER['REMOTE_ADDR'];
$_SESSION['useragent'] = $_SERVER['HTTP_USER_AGENT'];
$_SESSION['lastaccess'] = time();


if(isset($_POST['Back'])){
  header('location:login.php');
}

if(isset($_POST['Next'])){
  $uid = $_SESSION['UID'] ;

  mysqli_query($conn, "UPDATE `users` SET QR = 1  WHERE UserID = '$uid'") or die('query failed');
}

// if the submit(login) button is pressed,
if(isset($_POST['submit'])){
  // These two functions are important for extra security purpose in the signup form:
  // The FILTER_SANITIZE_STRING filter removes tags and remove or encode special characters from a string.
  // mysqli_real_escape_string() function escapes special characters in a string and prevents against sql attacks

  // fetch the email & password of the user
   $OTP = mysqli_real_escape_string($conn, filter_var($_POST['OTP'], FILTER_SANITIZE_STRING));
// _____________________________________________________________________________

    $uid = $_SESSION['UID'];
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE Userid = '$uid' ") or die('query failed');

   // if the rows returned are more than 0, then:
   if(mysqli_num_rows($select_users) > 0){
      $row = mysqli_fetch_assoc($select_users);
      $secret_key = $row['2fa'];
      $FailedLogin = $row['FailedLogin'];

      if ($FailedLogin > 2)
      {
        $msg = $FailedLogin . " Failed OTP Attempts Were Captured On The Account " . $row['email'];
        Hacking_Detected($msg,$msg);
      }



      $google2fa = new \PragmaRX\Google2FA\Google2FA();
      if ($google2fa->verifyKey($secret_key, $OTP)) {

        mysqli_query($conn, "UPDATE `users` SET FailedLogin = 0  WHERE UserID = '$uid'") or die('query failed');
        // if the user is an admin, save his credetials in the session and redirect him to the admin page
        if($row['type'] == 'admin'){
           $_SESSION['admin_id'] = $row['UserID'];
           header('location:adminDash.php');

  // _____________________________________________________________________________

        // if the user is not an admin, save his credetials in the session and redirect him to the home page
        }elseif($row['type'] == 'user'){
           $_SESSION['user_id'] = $row['UserID'];
           header('location:home.php');
        }

  // _____________________________________________________________________________
        elseif($row['type'] == 'employee'){
           $_SESSION['employee_id'] = $row['UserID'];
           header('location:employee.php');
        }
      } else {

        $uid = $_SESSION['UID'];
        $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE UserID = '$uid'") or die('query failed');
        if(mysqli_num_rows($select_users) > 0){
          // Return an associative array of the user's data
           $row = mysqli_fetch_assoc($select_users);
           $uid = $row['UserID'];
           $FailedLogin = $row['FailedLogin'] + 1;
           mysqli_query($conn, "UPDATE `users` SET FailedLogin = $FailedLogin  WHERE UserID = '$uid'") or die('query failed');
         }
        $message[] = 'Incorrect OTP!'; // store notification message

      }
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
 <title>Login Page</title>
</head>
<body>

 <?php include 'Templates/notification.php' ?>

 <div class="login-wrapper">
   <form action="Authenticate.php" method="POST" class="form">
     <img class="AvatarIcon" src="images/avatar.png" alt="">
     <h2>OTP</h2>
     <div class="input-group">
       <input type="number" name="OTP" id="loginUser" required>
       <label for="OTP">OTP</label>
     </div>
     <input type="submit" name="submit" value="Authenticate" class="submit-btn">
     <br><br>
     <span class="mssg">Use Your Google Authenticator APP</span>
   </form>
 </div>
</body>?
</html>
