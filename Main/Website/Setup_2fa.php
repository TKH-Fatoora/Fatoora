<?php

// connection to database
include 'Templates/config.php';

include_once(__DIR__.'/vendor/autoload.php');
use PragmaRX\Google2FA;
// start user session
session_start();

// _____________________________________________________________________________

$uid = $_SESSION['UID'];

$select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE Userid = '$uid' ") or die('query failed');
// if the rows returned are more than 0, then:
if(mysqli_num_rows($select_users) > 0){
   $row = mysqli_fetch_assoc($select_users);
   if ($row['QR'] == 0){
         $secret_key = $row['2fa'];
         $email = $row['email'];
         $google2fa = new \PragmaRX\Google2FA\Google2FA();

         $text = $google2fa->getQRCodeUrl(
           'Fatoora.com',
           $email,
           $secret_key
         );

         $image_url = 'https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl='.$text;
       }
       else
       {
         header('location:authenticate.php');
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
   <title>2FA</title>
 </head>
 <body>

   <?php include 'Templates/notification.php' ?>

   <div class="login-wrapper">
     <form action="Authenticate.php" method="POST" class="form">
       <img class="AvatarIcon" src="images/avatar.png" alt="">
       <h2>Google Authenticator</h2>
       <div class="input-group">
         <img class="OTPImage" src="<?php echo htmlspecialchars($image_url); ?>" alt="">

       </div>
      <br>
        <div class="Buttons">
          <input type="submit" name="Back" value="Back" class="back-btn">
          <input type="submit" name="Next" value="Next" class="submit-btn">
        </div>

     </form>
   </div>
 </body>?
 </html>
