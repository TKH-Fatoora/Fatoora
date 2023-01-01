<?php
// connection to databse
@include 'Templates/config.php';

// start user session
session_start();

// prevent session hijacking
@include 'Templates/session_hijacking_prevention.php';

// fetching the value for the user id
$admin_id = $_SESSION['selected_user_id'];

// _____________________________________________________________________________

// if admin id is not set, then:
if(!isset($admin_id)){
  /// log user out
   header('location:logout.php');
};

// fetching the value for the selected user id
$selected_user_id = $_SESSION['selected_user_id'];

// _____________________________________________________________________________
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>User Statistics</title>
    <!-- css style sheet link -->
    <link rel="stylesheet" href="CSS/statistics.css">
    <!-- chart.js link -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- set content's width according to current screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

<!--_______________________________________________________________________  -->

  </head>
  <body>
    <?php include 'Templates/notification.php' ?>
    <?php include 'Templates/adminNav.php' ?>

<!--_______________________________________________________________________  -->

  <section class="statistics">
    <!-- print out selected user id -->
    <h1>Statistics for UID: <span><?php echo htmlspecialchars($selected_user_id)?></span></h1>
    <div class="container">

<!--_______________________________________________________________________  -->
      <?php
      // select and calculate the totals per category for the selected user
      $select_user_categories = mysqli_query($conn, "SELECT SUM(amount) as ctotal, category FROM expenses WHERE UserID = '$selected_user_id' group by category;") or die('query failed');

      $category = '';
      $ctotal = '';

      // if the rows returned are more than 0, then:
      if(mysqli_num_rows($select_user_categories) > 0){
        // Return an associative array of the user's data
        while($row = mysqli_fetch_assoc($select_user_categories)){
          $category = $category.$row['category'].', ';
          $ctotal = $ctotal.$row['ctotal'].', ';
        }}
        ?>
<!--_______________________________________________________________________  -->

        <!-- input the stored values  -->
        <input type="hidden" name="" id="category" value="<?php echo htmlspecialchars($category) ?>">
        <input type="hidden" name="" id="ctotal" value="<?php echo htmlspecialchars($ctotal) ?>">

        <!--_______________________________________________________________________  -->

        <div class="pieChart">
          <h3>Expenses per Category</h3>
          <!-- pie chart 1 -->
          <canvas id="myChart"></canvas>
        </div>

        <!--_______________________________________________________________________  -->

        <?php
        // select and calculate the totals per payment method for the selected user
        $select_user_method = mysqli_query($conn, "SELECT SUM(amount) as mtotal, method FROM expenses WHERE UserID = '$selected_user_id' group by method;") or die('query failed');

        $method = '';
        $mtotal = '';

        // if the rows returned are more than 0, then:
        if(mysqli_num_rows($select_user_method) > 0){
          // Return an associative array of the user's data
          while($row = mysqli_fetch_assoc($select_user_method)){
            $method = $method.$row['method'].', ';
            $mtotal = $mtotal.$row['mtotal'].', ';
          }}
          ?>

<!--_______________________________________________________________________  -->

          <!-- input the stored values  -->
          <input type="hidden" name="" id="method" value="<?php echo htmlspecialchars($method); ?>">
          <input type="hidden" name="" id="mtotal" value="<?php echo htmlspecialchars($mtotal); ?>">

<!--_______________________________________________________________________  -->


          <div class="pieChart">
            <h3>Expenses per Payment Method</h3>
            <!-- pie chart 2 -->
            <canvas id="myChart2"></canvas>
          </div>

<!--_______________________________________________________________________  -->

    </div>
    <div class="back">

      <a href="adminUsers.php" class="btn">Back</a>
    </div>
  </section>

    <script type="text/javascript" src="Scripts/statistics.js"></script>
  </body>
</html>
