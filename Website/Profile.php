<?php

include 'Templates/config.php';

session_start();


if(isset($_SESSION["user_id"]))
{
  $user_id = $_SESSION['user_id'];
}
else if(isset($_SESSION["admin_id"]))
{
  $user_id = $_SESSION['admin_id'];
}else {
  header('location:login.php');
}

$selected_user = mysqli_query($conn, "SELECT * FROM `users` WHERE UserID = '$user_id'") or die('query failed');

$current_user = mysqli_fetch_assoc($selected_user);


if(isset($_POST['submit'])){
  // These two functions are important for extra security purpose in the signup form:
  // The FILTER_SANITIZE_STRING filter removes tags and remove or encode special characters from a string.
  // mysqli_real_escape_string() function escapes special characters in a string and prevents against sql attacks
  // passwords md5 hashing for an extra layer of security for the users

  // fetch the username, email, password & confirm password of the user
   $name = mysqli_real_escape_string($conn, filter_var($_POST['name'], FILTER_SANITIZE_STRING));
   $email = mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_STRING));
   $pass = mysqli_real_escape_string($conn, md5(filter_var($_POST['password'], FILTER_SANITIZE_STRING)));
   $cpass = mysqli_real_escape_string($conn, md5(filter_var($_POST['confirmPassword'], FILTER_SANITIZE_STRING)));
   $dob = mysqli_real_escape_string($conn, $_POST['DOB']);

 // _____________________________________________________________________________

    // select all users that have the same email that the user just entered from the users table in the database, if possible
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    // if the rows returned are more than 0, that means that this email was used already
    if(mysqli_num_rows($select_users) > 0){
          $message[] = 'User already exists!'; // store notification message
       }else{
         // if the 2 paaswords entered do not match
          if($pass != $cpass){
             $message[] = 'Passwords do not match!'; // store notification message
 // _____________________________________________________________________________
          }else{
            // if all input was valid, insert these values into the users table in the databsae
             mysqli_query($conn, "INSERT INTO `users`(name, email, password, birthdate) VALUES('$name', '$email', '$pass', '$dob')") or die('query failed');
             $message[] = 'Registered successfully!'; // store notification message
             // redirect user to the login page
             header('location:login.php');
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
  <link rel="stylesheet" href="CSS/sign-up.css">
  <title>Sign-Up Page</title>
</head>
<body>

  <?php include 'Templates/notification.php' ?>

  <div class="login-wrapper">
    <form action="Profile.php" method='post' class="form">
      <img src="images/avatar.png" alt="">
      <h2>Profile</h2>
      <div class="input-group">
        <input type="text" name="name" id="loginUser" value="<?php echo htmlspecialchars($current_user["name"]) ?>" required>
        <label for="loginUser">Name</label>
      </div>
      <div class="input-group">
        <input type="email" name="email" id="loginEmail" value="<?php echo htmlspecialchars($current_user["email"]) ?>" readonly>
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
        <input type="date" name="DOB" id="loginDOB" value="<?php echo htmlspecialchars($current_user["birthdate"]) ?>" readonly>
        <label for="loginDOB">Date of Birth</label>
      </div>
      <input type="submit" name="submit" value="Update" class="submit-btn">
      <br>

    </form>
  </div>
</body>
</html>
