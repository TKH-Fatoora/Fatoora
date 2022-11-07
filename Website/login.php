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
  <div class="login-wrapper">
    <form action="" class="form">
      <img src="images/avatar.png" alt="">
      <h2>Login</h2>
      <div class="input-group">
        <input type="text" name="loginUser" id="loginUser" required>
        <label for="loginUser">User Name</label>
      </div>
      <div class="input-group">
        <input type="password" name="loginPassword" id="loginPassword" required>
        <label for="loginPassword">Password</label>
      </div>
      <input type="submit" value="Login" class="submit-btn">
      <a href="signup.php" class="forgot-pw">New Here? Sign Up</a>
    </form>
  </div>
</body>
</html>
