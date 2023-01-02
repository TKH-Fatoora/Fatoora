<?php
// connection to database
include 'Templates/config.php';

// starting the session
session_start();

// prevent session hijacking
@include 'Templates/session_hijacking_prevention.php';

// _____________________________________________________________________________

if(isset($_SESSION["user_id"]))
{ // fetching the value for the user id
  $user_id = $_SESSION['user_id'];
}
else if(isset($_SESSION["admin_id"]))
{ // fetching the value for the admin id
  $user_id = $_SESSION['admin_id'];
}
else if(isset($_SESSION["employee_id"]))
{ // fetching the value for the employee id
  $user_id = $_SESSION['employee_id'];
}
else if(isset($_SESSION["security_id"]))
{ // fetching the value for the security admin id
  $user_id = $_SESSION['security_id'];
}else { // log user out
  header('location:logout.php');
}

// _____________________________________________________________________________

// fetching the value for the user account status
$blocked = $_SESSION['is_blocked'];

// if user id is blocked, then:
if($blocked == 1){
  // redirect user to blocked page
   header('location:blocked.php');
};

// _____________________________________________________________________________

// selected the current user's data from the database
$selected_user = mysqli_query($conn, "SELECT * FROM `users` WHERE UserID = '$user_id'") or die('query failed');

// store current user's data  in an associative array
$current_user = mysqli_fetch_assoc($selected_user);

// _____________________________________________________________________________
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Profile</title>
  <!-- styles sheet link -->
  <link rel="stylesheet" href="CSS/sign-up.css">
  <!-- set content's width according to current screen width -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<!-- _______________________________________________________________________ -->

<body>
  <?php include 'Templates/notification.php' ?>

  <div class="login-wrapper">
    <form action="Profile.php" method='post' class="form">

      <!-- CSRF token -->
      <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION["csrf"]);?>">

<!-- _______________________________________________________________________ -->

      <!-- print out user's data -->
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

<!-- _______________________________________________________________________ -->

      <!-- button to go back one page -->
      <input type="button" name="back" value="Back" class="submit-btn" id="back-btn">

    </form>
  </div>
  <!-- link to javascript file -->
  <script type="text/javascript" src="Scripts/back.js"></script>
</body>
</html>
