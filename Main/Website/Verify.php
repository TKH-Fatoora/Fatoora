<?php

// connection to database
include 'Templates/config.php';
include 'Templates/Email.php';

// start user session
session_start();

if(isset($_POST['Verify'])){


  // These two functions are important for extra security purpose in the signup form:
  // The FILTER_SANITIZE_STRING filter removes tags and remove or encode special characters from a string.
  // mysqli_real_escape_string() function escapes special characters in a string and prevents against sql attacks

  // fetch the email & password of the user
   $VOTP = mysqli_real_escape_string($conn, filter_var($_POST['VOTP'], FILTER_SANITIZE_STRING));
   $Vpurp = mysqli_real_escape_string($conn, filter_var($_POST['VPurpose'], FILTER_SANITIZE_STRING));

   $Vemail = mysqli_real_escape_string($conn, filter_var($_POST['Vemail'], FILTER_SANITIZE_STRING));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$Vemail'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $row = mysqli_fetch_assoc($select_users);
      $VOTPOG = $row["VOTP"];
      $uid = $row["UserID"];
      $name = $row["name"];
      $email = $row["email"];

      // Compare the Original VOTP with the new OTP
      if ($VOTPOG == $VOTP)
      {
        // Set User Account To Verified
        mysqli_query($conn, "UPDATE `users` SET VOTP = '', Verified = 1  WHERE UserID = '$uid'") or die('query failed');
        // Send a Verfication Acknowledgement Email
        SendEmail($email,$name,"Your Account has Been Verified");
        if ($Vpurp == 'signup')
        {
          header("location:login.php");
        }elseif ($Vpurp == 'resetP') {
          header("location:forgetPass.php");
        }
        $message[] = 'Correct OTP';
      }
      else
      {
        $message[] = 'Incorrect OTP';
      }
    }

 }else
 {
// _____________________________________________________________________________

$email = $_SESSION["Vemail"];

$select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' ") or die('query failed');
// if the rows returned are more than 0, then:
if(mysqli_num_rows($select_users) > 0){
  $row = mysqli_fetch_assoc($select_users);
  $uid = $row["UserID"];
  $name = $row["name"];
  $vrfy = $row["Verified"];

  if ($vrfy == 1)
  {
    header('location:login.php');
  }else
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

 <?php include 'Templates/notification.php'; ?>

 <div class="login-wrapper">
   <form action="Verify.php" method="POST" class="form">
     <img class="AvatarIcon" src="images/avatar.png" alt="">
     <h2>Email Verification</h2>
     <p> pleae Check your email <?php echo htmlspecialchars($_SESSION["Vemail"]); ?> for the Verification Number </p>
     <br>
     <div class="input-group">
       <input type="hidden" name="Vemail" value="<?php echo htmlspecialchars($_SESSION["Vemail"]); ?>">
       <input type="hidden" name="VPurpose" value="<?php echo htmlspecialchars($_SESSION["VPurpose"]); ?>">
       <input type="number" name="VOTP" id="loginUser" required>
       <label for="VOTP">Verify OTP</label>
     </div>
    <br>
      <div class="Buttons">
        <!-- <input type="submit" name="Skip" value="ski" class="back-btn"> -->
        <input type="submit" name="Verify" value="Verify" class="submit-btn">
      </div>

   </form>
 </div>
</body>?
</html>
