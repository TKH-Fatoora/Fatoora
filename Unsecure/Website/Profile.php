<?php

include 'Templates/config.php';

session_start();


$selected_user = mysqli_query($conn, "SELECT * FROM `users` WHERE UserID = '$user_id'") or die('query failed');

$current_user = mysqli_fetch_assoc($selected_user);

if(isset($_POST['submit'])){

  // fetch the username, email, password & confirm password of the user
   $name = $_POST['name'];
   $pass = $_POST['password'];
   $cpass = $_POST['confirmPassword'];
   $_SESSION['user_name'] = $name;

 // _____________________________________________________________________________
    if (isset($pass)){
      // if the 2 paaswords entered do not match
       if($pass != $cpass){
          $message[] = 'Passwords do not match!'; // store notification message
   // _____________________________________________________________________________
       }else{
         // if all input was valid, insert these values into the users table in the databsae
          mysqli_query($conn, "UPDATE `users` SET name = '$name', password = '$pass'  WHERE UserID = '$user_id'") or die('query failed');
          header('location:Profile.php');
       }
    }else{
      mysqli_query($conn, "UPDATE `users` SET name = '$name' WHERE UserID = '$user_id'") or die('query failed');
      header('location:Profile.php');

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
      <img src="images/avatar.png" alt="">
      <h2>Profile</h2>
      <div class="input-group">
        <input type="text" name="name" id="loginUser" value="<?php echo $current_user["name"] ?>" required>
        <label for="loginUser">Name</label>
      </div>
      <div class="input-group">
        <input type="email" name="email" id="loginEmail" value="<?php echo $current_user["email"] ?>" readonly>
        <label for="loginEmail">Email</label>
      </div>
      <div class="input-group">
        <input type="password" name="password" id="loginPassword" >
        <label for="loginPassword">Password</label>
      </div>
      <div class="input-group">
        <input type="password" name="confirmPassword" id="loginCPassword" >
        <label for="loginPassword">Confirm Password</label>
      </div>
      <div class="input-group">
        <input type="date" name="DOB" id="loginDOB" value="<?php echo $current_user["birthdate"] ?>" readonly>
        <label for="loginDOB">Date of Birth</label>
      </div>
      <input type="submit" name="submit" value="Update" class="submit-btn"><br>

      <input type="button" name="back" value="Back" class="submit-btn" id="back-btn">
    </form>
  </div>
<script type="text/javascript" src="Scripts/back.js"></script>
</body>
</html>
