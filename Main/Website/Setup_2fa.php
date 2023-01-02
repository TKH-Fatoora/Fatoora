<?php

// connection to database
include 'Templates/config.php';

// Composer Include Libraries
include_once(__DIR__.'/vendor/autoload.php');

// Use Google 2FA Library
use PragmaRX\Google2FA;

// start user session
session_start();

// _____________________________________________________________________________
// Get User ID
$uid = $_SESSION['UID'];

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
  Hacking_Detected("Insufficent Access",$alertuserID,"Unauthorized Access to Admin Users pasge Was Attempted","Insufficent Access",2);
  // redirect user to log in again
   header('location:logout.php');
};

// Get User Using ID
$select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE Userid = '$uid' ") or die('query failed');
// if the rows returned are more than 0, then:
if(mysqli_num_rows($select_users) > 0){
   // Format Data as an Associative Array
   $row = mysqli_fetch_assoc($select_users);
   // Check If User Has Acquired QR Code Before or Not
   if ($row['QR'] == 0){
        //  IF Not
        // Get Secret Token from DB
         $secret_key = $row['2fa'];
        // Get User Email
         $email = $row['email'];

        // Create A Google API Object
         $google2fa = new \PragmaRX\Google2FA\Google2FA();

         // Create  QR Code Using Fatoora.com, The User Email, And the Token
         $text = $google2fa->getQRCodeUrl('Fatoora.com', $email,$secret_key);

         // Construct and Store QR Image URL in a Variable
         $image_url = 'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl='.$text;
       }
       else
       {
         // If QR is Set Head to The authenticate page.
         header('location:authenticate.php');
       }

    }
 ?>


 <!DOCTYPE html>
 <html lang="en">
 <head>
   <!-- Metadata -->
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <!-- Stylesheet -->
   <link rel="stylesheet" href="CSS/login.css">
   <!-- Title -->
   <title>2FA</title>
 </head>
 <body>
   <!-- Notifications -->
   <?php include 'Templates/notification.php' ?>

   <!-- QR Code Display Form -->
   <div class="login-wrapper">
     <form action="Authenticate.php" method="POST" class="form">
       <img class="AvatarIcon" src="images/avatar.png" alt="">
       <!-- Form Title -->
       <h2>Google Authenticator</h2>
       <!-- QR Image  -->
       <div class="input-group">
         <img class="OTPImage" src="<?php echo htmlspecialchars($image_url); ?>" alt="">
       </div>
       <br>
       <!-- Buttons Div -->
        <div class="Buttons">
          <input type="submit" name="Back" value="Back" class="back-btn">
          <input type="submit" name="Next" value="Next" class="submit-btn">
        </div>
     </form>
   </div>
 </body>?
 </html>
