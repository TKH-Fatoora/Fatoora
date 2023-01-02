<?php

// connection to database
include 'Templates/config.php';
include 'Templates/Email.php';

// start user session
session_start();

// _____________________________________________________________________________

// When Form Submits Back
if(isset($_POST['Back'])){
  // Go Back to Login Page
  header('location:login.php');
}
// _____________________________________________________________________________

if(isset($_POST['Verify'])){
  // These two functions are important for extra security purpose in the signup form:
  // The FILTER_SANITIZE_STRING filter removes tags and remove or encode special characters from a string.
  // mysqli_real_escape_string() function escapes special characters in a string and prevents against sql attacks

  // fetch the Verification email, OTP & purpose  of the user
   $VOTP = mysqli_real_escape_string($conn, filter_var($_POST['VOTP'], FILTER_SANITIZE_STRING));
   $Vpurp = mysqli_real_escape_string($conn, filter_var($_POST['VPurpose'], FILTER_SANITIZE_STRING));
   $Vemail = mysqli_real_escape_string($conn, filter_var($_POST['Vemail'], FILTER_SANITIZE_STRING));

   // get User With the Supplied Email
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$Vemail'") or die('query failed');

   // Check if User Exists
   if(mysqli_num_rows($select_users) > 0){
      // Format Data As Associative Array
      $row = mysqli_fetch_assoc($select_users);
      $VOTPOG = $row["VOTP"];  //Get the Original Verfication OTP from DB Record
      $uid = $row["UserID"];   // Get User ID
      $name = $row["name"];    // Get User Name
      $email = $row["email"];  // Get User email

      // Compare the Original VOTP with the new OTP
      if ($VOTPOG == $VOTP)
      {
        // IF Correct VOTP
        // Set User Account To Verified
        mysqli_query($conn, "UPDATE `users` SET VOTP = '', Verified = 1  WHERE UserID = '$uid'") or die('query failed');
        // Send a Verfication Acknowledgement Email
        SendEmail($email,$name,"Your Account has Been Verified");
        // Check Verification Purpose
        if ($Vpurp == 'signup')
        {
          // If Signup Head to Login
          header("location:login.php");
        }
        elseif ($Vpurp == 'resetP') {
          // If Reset Password Head to Forget Password
          header("location:forgetPass.php");
        }

        $message[] = 'Correct OTP'; // Store Notification message
      }
      else
      {
        // If Incorrect VOTP
        $message[] = 'Incorrect OTP'; // Store Notification message
      }
    }

 }
 // _____________________________________________________________________________
 else {
    // Get The Supplied Verification Email from the previous Form.
    $email = $_SESSION["Vemail"];

    // Get User By Email
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' ") or die('query failed');

    // if the rows returned are more than 0, then:
    if(mysqli_num_rows($select_users) > 0){
      // Format as Associative Array
      $row = mysqli_fetch_assoc($select_users);
      $uid = $row["UserID"];     // Get User ID
      $name = $row["name"];      // Get User Name
      $vrfy = $row["Verified"];  // Get User Verfication Status

      // Check If User Is Verified
      if ($vrfy == 1)
      {
        // If Verified, Skip verification and Go to Login
        header('location:login.php');
      }
      else
      {
        // Generating A 6 digit random Verification one time Password
        $six_digit_random_number = random_int(100000, 999999);
        // Creating the email Body Content
        $email_msg = "Your OTP: " . $six_digit_random_number;
        // Storing the VOTP in the Database
        mysqli_query($conn, "UPDATE `users` SET VOTP = '$six_digit_random_number', Verified = 0  WHERE UserID = '$uid'") or die('query failed');
        // Sending the Email
        SendEmail($email,$name,$email_msg);
  }
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
 <!-- Title -->
 <title>Login Page</title>
</head>
<body>
 <!-- Notification  -->
 <?php include 'Templates/notification.php'; ?>

 <!-- Verificatio OTP Form  -->
 <div class="login-wrapper">
   <form action="Verify.php" method="POST" class="form">
     <img class="AvatarIcon" src="images/avatar.png" alt="">
     <!-- Form Title -->
     <h2>Email Verification</h2>
     <!-- Info Span -->
     <p> pleae Check your email <?php echo htmlspecialchars($_SESSION["Vemail"]); ?> for the Verification Number </p>
     <br>

        <!-- Hiiden attributes -->
       <input type="hidden" name="Vemail" value="<?php echo htmlspecialchars($_SESSION["Vemail"]); ?>">
       <input type="hidden" name="VPurpose" value="<?php echo htmlspecialchars($_SESSION["VPurpose"]); ?>">

       <!-- VOTP input Field -->
       <div class="input-group">
         <input type="number" name="VOTP" id="loginUser" required>
         <label for="VOTP">Verify OTP</label>
       </div>
    <br>
      <!-- Buttons  Div-->
      <div class="Buttons">
        <input type="submit" name="Verify" value="Verify" class="submit-btn">
        <input type="submit" name="Back" value="Back" class="back-btn">
      </div>

   </form>
 </div>
</body>?
</html>
