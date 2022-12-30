<?php

include 'Templates/config.php';

session_start();

if(isset($_POST['submit'])){
  // These two functions are important for extra security purpose in the signup form:
  // The FILTER_SANITIZE_STRING filter removes tags and remove or encode special characters from a string.
  // mysqli_real_escape_string() function escapes special characters in a string and prevents against sql attacks
  // passwords md5 hashing for an extra layer of security for the users

  // fetch the  email, password & confirm password of the user
   $email = mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_STRING));

 // _____________________________________________________________________________

    // select all users that have the same email that the user just entered from the users table in the database, if possible
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    // if the rows returned are more than 0, that means that this email was used already
    if(mysqli_num_rows($select_users) > 0){
          $row = mysqli_fetch_assoc($select_users);
          $uid = $row["UserID"];
          $name = $row["name"];
          $vrfy = $row["Verified"];
          $_SESSION["Vemail"] = $email;
          $_SESSION["VPurpose"] = "resetP";
          // redirect user to the Verify page
          header('location:Verify.php');

          mysqli_query($conn, "UPDATE `users` SET VOTP = '$six_digit_random_number', Verified = 0  WHERE UserID = '$uid'") or die('query failed');

       }else{
         $message[] = 'User doesn\'t exist!'; // store notification message
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
  <title>Forgot Password</title>
</head>
<body>

  <?php include 'Templates/notification.php' ?>

  <div class="login-wrapper">
    <form action="resetPasswordAccount.php" method="POST" class="form">
      <img class="AvatarIcon" src="images/avatar.png" alt="">
      <h2>Change Password</h2>
      <div class="input-group">
        <input type="email" name="email" id="loginUser" required>
        <label for="email">Email</label>
      </div>
      <input type="submit" name="submit" value="Submit" class="submit-btn">

    </form>
  </div>
</body>?
</html>
