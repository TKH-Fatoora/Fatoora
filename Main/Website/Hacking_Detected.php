<?php
// starting the session
session_start();

// prevent session hijacking
@include 'Templates/session_hijacking_prevention.php';

// if hacking reason was set,
if (isset($_SESSION["HACK"])) {
  $reason = $_SESSION["HACK"]; // store the reason from the server in a variable
}
else{ // if hacking reason was not set,
  header("location:logout.php"); // log the user out
}
 ?>
<!-- _______________________________________________________________________ -->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>Hacking Detected</title>
    <meta charset="utf-8">
    <!-- stylesheet link -->
    <link rel="stylesheet" href="CSS\Hacking_Detected.css">
    <!-- set content's width according to current screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  </head>

<!-- _______________________________________________________________________ -->
  <body>
    <main class="bl_page404">
      <br><br>
      <h1>Hacking Detected!</h1>
      <p>Sorry! You are currently restricted from the page you are looking for.</p>
      <!-- Hacking detection reason -->
      <p>Reason: <?php echo htmlspecialchars($reason); ?></p>
      <div class="bl_page404__wrapper">
        <img src="Images/HackingDetected.png" alt="HackingDetected.png">
        <div class="bl_page404__el1"></div>
        <div class="bl_page404__el2"></div>
        <div class="bl_page404__el3"></div>
      </div>
    </main>
  </body>
</html>
