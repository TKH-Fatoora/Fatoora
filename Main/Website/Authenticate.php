<?php

// Database Connection Template
@include 'Templates/config.php';
// Hacking Detectted Function Template
include 'Templates/HackingDetectedTemp.php';

// Composer Laad Libraries
include_once(__DIR__.'/vendor/autoload.php');

// Using the Google 2 Factor Authentication library
use PragmaRX\Google2FA;

// Starting Session
session_start();

// Setting Session Hijacking Paramters
$_SESSION['ipaddress'] = $_SERVER['REMOTE_ADDR'];       // Storing User Remote Ip Address
$_SESSION['useragent'] = $_SERVER['HTTP_USER_AGENT'];   // Storing the User's Browser Info
$_SESSION['lastaccess'] = time();                       // Storing User Last Access time


// fetching the value for the admin id
$uid = $_SESSION['UID'];

// _____________________________________________________________________________

// if admin id is not set, then:
if(!isset($uid)){
  // Check if User is Logged in and Has an ID
  if(isset($_SESSION['UID']))
  {
    // If so, Store the Attacker UID
    $alertuserID = $_SESSION['UID'];
  }
  else
  {
    // if not Set ID to 0
    $alertuserID = 0;
  }
  // Send an Insufficent Access ALert
  Hacking_Detected("Insufficent Access",$alertuserID,"Unauthorized Access Attempt to Authentication pasge","Insufficent Access",2);
  // redirect user to log in again
   header('location:logout.php');
};

// _____________________________________________________________________________

// When Form Submits Back
if(isset($_POST['Back'])){
  // Go Back to Login Page
  header('location:login.php');
}
// _____________________________________________________________________________

// When Form Submits Next
if(isset($_POST['Next'])){

  // Set QR Value in DB to 1 to indicate that user has acquired their QR code for the Authenticator
  mysqli_query($conn, "UPDATE `users` SET QR = 1  WHERE UserID = '$uid'") or die('query failed');
}
// _____________________________________________________________________________

// if the submit(login) button is pressed,
if(isset($_POST['submit'])){
  // These two functions are important for extra security purpose in the signup form:
  // The FILTER_SANITIZE_STRING filter removes tags and remove or encode special characters from a string.
  // mysqli_real_escape_string() function escapes special characters in a string and prevents against sql attacks

  // fetch the OTP from the user
   $OTP = mysqli_real_escape_string($conn, filter_var($_POST['OTP'], FILTER_SANITIZE_STRING));
// _____________________________________________________________________________
    // Get User by their ID
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE Userid = '$uid' ") or die('query failed');

   // if the rows returned are more than 0, then:
   if(mysqli_num_rows($select_users) > 0){
      // Format Data as Associative Array
      $row = mysqli_fetch_assoc($select_users);
      // Get the 2fa Token from the retreived record in the Database
      $secret_key = $row['2fa'];
      // Get Number of Failed Login Attempts
      $FailedLogin = $row['FailedLogin'];

      // Check if User Has Failed to Login 3 TImes
      if ($FailedLogin > 2)
      {
        // Generating Alert Message
        $msg = $FailedLogin . " Failed OTP Attempts Were Captured On The Account " . $row['email'];
        // Generate Alert // TODO:
        Hacking_Detected($msg,$uid,$msg,"Authentication",2);
      }

// _____________________________________________________________________________
      //Create A Google 2FA Object
      $google2fa = new \PragmaRX\Google2FA\Google2FA();

      // Using the the User Stored Token,and OTP. the Object verifies if the user has access or not
      if ($google2fa->verifyKey($secret_key, $OTP)) {
        // If hass Access
        // Reset Failed Attempts
        mysqli_query($conn, "UPDATE `users` SET FailedLogin = 0  WHERE UserID = '$uid'") or die('query failed');

  // Log User In Accroding to privilege
  // _____________________________________________________________________________
        // if the user is an admin, save his credetials in the session and redirect him to the admin page
        if($row['type'] == 'admin'){
           $_SESSION['admin_id'] = $row['UserID'];
           header('location:adminDash.php');
       }
  // _____________________________________________________________________________

        // if the user is an normal user, save his credetials in the session and redirect him to the home page
        elseif($row['type'] == 'user'){
           $_SESSION['user_id'] = $row['UserID'];
           header('location:home.php');
        }
  // _____________________________________________________________________________
        // if the user is an employee, save his credetials in the session and redirect him to the employee page
        elseif($row['type'] == 'employee'){
           $_SESSION['employee_id'] = $row['UserID'];
           header('location:employee.php');
        }
  // _____________________________________________________________________________

        // if the user is an security team member, save his credetials in the session and redirect him to the security page
        elseif($row['type'] == 'security'){
           $_SESSION['security_id'] = $row['UserID'];
           header('location:security.php');
        }

        // Store User State whether Blocked or not in session.
        $_SESSION['is_blocked'] = $row['blocked'];

  // _____________________________________________________________________________
      } else {
        // IF OTP is Incorrect

        // Get User By UID
        $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE UserID = '$uid'") or die('query failed');

        if(mysqli_num_rows($select_users) > 0){
          // Return an associative array of the user's data
           $row = mysqli_fetch_assoc($select_users);
           // Get UID from record
           $uid = $row['UserID'];
           // Get and Increment Failed Login Counter by 1
           $FailedLogin = $row['FailedLogin'] + 1;
           // Store New Failed Login Count
           mysqli_query($conn, "UPDATE `users` SET FailedLogin = $FailedLogin  WHERE UserID = '$uid'") or die('query failed');
         }
        $message[] = 'Incorrect OTP!'; // store notification message
      }
<<<<<<< HEAD
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
 <link rel="stylesheet" href="CSS/login.css">
 <!-- title  -->
 <title>Login Page</title>
=======
}
}
 ?>
 <!-- _______________________________________________________________________ -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Page</title>
  <!-- stylesheet link -->
  <link rel="stylesheet" href="CSS/login.css">
   <!-- set content's width according to current screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
>>>>>>> 16f34c97c59c9b08599195a0027643ed65a654e2
</head>

<!-- _______________________________________________________________________ -->
<body>

 <!-- Notifications -->
 <?php include 'Templates/notification.php' ?>
 
 <!-- _______________________________________________________________________ -->

 <!-- Authentication DIV -->
 <div class="login-wrapper">
   <form action="Authenticate.php" method="POST" class="form">
     <img class="AvatarIcon" src="images/avatar.png" alt="">
     <!-- Form Title -->
     <h2>OTP</h2>

     <!-- OTP Input Field  -->
     <div class="input-group">
       <input type="number" name="OTP" id="loginUser" required>
       <label for="OTP">OTP</label>
     </div>
     <!-- Buttons Div -->
     <div class="Buttons">
       <input type="submit" name="Back" value="Back" class="back-btn">
       <input type="submit" name="submit" value="Authenticate" class="submit-btn">
     </div>
     <br><br>

     <!-- Info Span -->
     <span class="mssg">Use Your Google Authenticator APP</span>
   </form>
 </div>
</body>?
</html>
