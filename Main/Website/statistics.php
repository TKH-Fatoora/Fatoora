<?php
// connection to databse
@include 'Templates/config.php';

// start user session
session_start();

// prevent session hijacking
@include 'Templates/session_hijacking_prevention.php';

// fetching the value for the user id
$user_id = $_SESSION['user_id'];

// _____________________________________________________________________________

// if admin id is not set, then:
if(!isset($user_id)){
  // Check if User is Logged in and Has an ID
  if(isset($_SESSION['UID']))
  {
    // If so, Store the Attacker UID
    $alertuserID = $_SESSION['UID'];
  }
  else
  {
    // if not Set ID to 0
    $alertuserID = 0;
  }
  // Send an Insufficent Access ALert
  Hacking_Detected("Insufficent Access",$alertuserID,"Unauthorized Access to Statistics page Was Attempted","Insufficent Access",2);
  // redirect user to log in again
   header('location:logout.php');
};

// fetching the value for the user id
$blocked = $_SESSION['is_blocked'];

// if user id is blocked, then:
if($blocked == 1){
  // redirect user to log in again
   header('location:blocked.php');
};

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <!-- Metadata -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Style Sheet -->
    <link rel="stylesheet" href="CSS/statistics.css">
    <!-- Title -->
    <title>Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
  <body>
    <!-- Notifications -->
    <?php include 'Templates/notification.php' ?>
    <!-- Navigation bar -->
    <?php include 'Templates/navbar.php' ?>

<!--_______________________________________________________________________  -->
  <!-- Page -->
  <section class="statistics">
    <!-- Page title -->
    <h1>Statistics</h1>
    <div class="container">

      <!--_______________________________________________________________________  -->
      <?php
      // Get All User Categories
      $select_user_categories = mysqli_query($conn, "SELECT SUM(amount) as ctotal, category FROM expenses WHERE UserID = '$user_id' group by category;") or die('query failed');

      // Variables Intialization
      $category = '';
      $ctotal = '';

      // if the rows returned are more than 0, then:
      if(mysqli_num_rows($select_user_categories) > 0){
        // Return an associative array of the user's data
        // loop Over Data
        while($row = mysqli_fetch_assoc($select_user_categories)){
          // Set categories to a Comma Separated List
          $category = $category.$row['category'].', ';
          // Set categories Totals to a Comma Separated List
          $ctotal = $ctotal.$row['ctotal'].', ';
        }}

        ?>

        <!-- Hidden Paramters For JS -->
        <input type="hidden" name="" id="category" value="<?php echo htmlspecialchars($category) ?>">
        <input type="hidden" name="" id="ctotal" value="<?php echo htmlspecialchars($ctotal) ?>">

        <!--_______________________________________________________________________  -->

        <!-- Categories Pie Chart  -->
        <div class="pieChart">
          <h3>Expenses per Category</h3>
          <canvas id="myChart"></canvas>
        </div>

        <!--_______________________________________________________________________  -->

        <?php

        // Get User Methods
        $select_user_method = mysqli_query($conn, "SELECT SUM(amount) as mtotal, method FROM expenses WHERE UserID = '$user_id' group by method;") or die('query failed');

        // Variables Intialization
        $method = '';
        $mtotal = '';

        // if the rows returned are more than 0, then:
        if(mysqli_num_rows($select_user_method) > 0){
          // Return an associative array of the user's data
          while($row = mysqli_fetch_assoc($select_user_method)){
            // Set Methods to a Comma Separated List
            $method = $method.$row['method'].', ';
            // Set Methods Totals to a Comma Separated List
            $mtotal = $mtotal.$row['mtotal'].', ';
          }}

          ?>

          <!-- Hidden Paramters For JS -->
          <input type="hidden" name="" id="method" value="<?php echo htmlspecialchars($method); ?>">
          <input type="hidden" name="" id="mtotal" value="<?php echo htmlspecialchars($mtotal); ?>">

          <!--_______________________________________________________________________  -->


          <!-- Methods Pie Chart -->
          <div class="pieChart">
            <h3>Expenses per Payment Method</h3>
            <canvas id="myChart2"></canvas>
          </div>

          <!--_______________________________________________________________________  -->

    </div>

  </section>

    <!-- Footer  -->
    <?php include 'Templates/footer.php' ?>
    <!-- Statiscts Script -->
    <script type="text/javascript" src="Scripts/statistics.js"></script>
  </body>
</html>
