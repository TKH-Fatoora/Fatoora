<?php

include 'Templates/config.php';

session_start();

// prevent session hijacking
@include 'Templates/session_hijacking_prevention.php';


if(isset($_SESSION["user_id"]))
{
  $user_id = $_SESSION['user_id'];
}
else if(isset($_SESSION["admin_id"]))
{
  $user_id = $_SESSION['admin_id'];
}
else if(isset($_SESSION["employee_id"]))
{
  $user_id = $_SESSION['employee_id'];
}
else if(isset($_SESSION["security_id"]))
{
  $user_id = $_SESSION['security_id'];
}else {
  header('location:logout.php');
}

$selected_user = mysqli_query($conn, "SELECT * FROM `users` WHERE UserID = '$user_id'") or die('query failed');

$current_user = mysqli_fetch_assoc($selected_user);

if (
  isset($_POST["csrf"]) &&
  isset($_SESSION["csrf"]) &&
  isset($_SESSION["csrf-expire"]) &&
  $_SESSION["csrf"]==$_POST["csrf"]
) {
  // (B1) EXPIRED
  if (time() >= $_SESSION["csrf-expire"]) {
    exit("csrf expired. Please reload form.");
    header('location:login.php');
  }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="CSS/sign-up.css">
  <title>Edit Profile</title>
</head>
<body>

  <?php include 'Templates/notification.php' ?>

  <div class="login-wrapper">
    <form action="Profile.php" method='post' class="form">
      <!-- CSRF token -->
      <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION["csrf"]);?>">

      <img src="images/avatar.png" alt="">
      <h2>Profile</h2>
      <div class="input-group">
        <input type="text" name="name" id="loginUser" value="<?php echo htmlspecialchars($current_user["name"]) ?>" readonly>
        <label for="loginUser">Name</label>
      </div>
      <div class="input-group">
        <input type="email" name="email" id="loginEmail" value="<?php echo htmlspecialchars($current_user["email"]) ?>" readonly>
        <label for="loginEmail">Email</label>
      </div>
      <div class="input-group">
        <input type="date" name="DOB" id="loginDOB" value="<?php echo htmlspecialchars($current_user["birthdate"]) ?>" readonly>
        <label for="loginDOB">Date of Birth</label>
      </div>

      <input type="button" name="back" value="Back" class="submit-btn" id="back-btn">
    </form>
  </div>
<script type="text/javascript" src="Scripts/back.js"></script>
</body>
</html>
