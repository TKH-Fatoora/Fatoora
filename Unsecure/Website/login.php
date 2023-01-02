<?php
// connection to database
@include 'Templates/config.php';

// start user session
session_start();

// _____________________________________________________________________________

// if the submit(login) button is pressed,
if(isset($_POST['submit'])){

  // fetch the email & password of the user
   $email = $_POST['email'];
   $pass = $_POST['password'];

// _____________________________________________________________________________

   // select all users that have the same email and password that the user just entered from the users table in the databse, if possible
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die("query failed");

   // if the rows returned are more than 0, then:
   if(mysqli_num_rows($select_users) > 0){

     // Return an associative array of the user's data
      $row = mysqli_fetch_assoc($select_users);
// _____________________________________________________________________________
      $cookie_name = "uid";
      $cookie_value = $row['UserID'];
      setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
// _____________________________________________________________________________

      $_SESSION['user_name'] = $row['name'];
      $_SESSION['user_email'] = $row['email'];

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
// _____________________________________________________________________________
      else{
         $message[] = 'no user found!'; // store notification message
      }
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
      <img src="images/avatar.png" alt="">
      <h2>Login</h2>
      <div class="input-group">
        <input type="text" name="email" id="loginUser" required>
        <label for="email">Email</label>
      </div>
      <div class="input-group">
        <input type="password" name="password" id="loginPassword" required>
        <label for="password">Password</label>
      </div>
      <input type="submit" name="submit" value="Login" class="submit-btn">
      <span class="mssg">New Here? <a href="signup.php">Sign Up</a> </span>
      <br><br>
      <span class="mssg"><a href="forgetPass.php">Forgot Password?</a> </span>
    </form>
  </div>
</body>?
</html>
