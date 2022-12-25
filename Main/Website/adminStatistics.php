<?php
// connection to databse
@include 'Templates/config.php';

// start user session
session_start();

// fetching the value for the user id
$admin_id = $_SESSION['admin_id'];

// _____________________________________________________________________________

// if user id is not set, then:
if(!isset($admin_id)){
  // redirect user to log in again
   header('location:login.php');
};
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>All Statistics</title>
    <link rel="stylesheet" href="CSS/statistics.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
  <body>
    <?php include 'Templates/notification.php' ?>
    <?php include 'Templates/adminNav.php' ?>

<!--_______________________________________________________________________  -->
  <section class="statistics">
    <h1>All Users Statistics</span></h1>
    <div class="container">

      <!--_______________________________________________________________________  -->
      <?php
      $select_user_categories = mysqli_query($conn, "SELECT SUM(amount) as ctotal, category FROM expenses group by category;") or die('query failed');

      $category = '';
      $ctotal = '';

      // if the rows returned are more than 0, then:
      if(mysqli_num_rows($select_user_categories) > 0){
        // Return an associative array of the user's data
        while($row = mysqli_fetch_assoc($select_user_categories)){
          $category = $category.$row['category'].', ';
          $ctotal = $ctotal.$row['ctotal'].', ';
        }}

        // for testing only
        // echo $category;
        // echo $ctotal;
        ?>

        <input type="hidden" name="" id="category" value="<?php echo htmlspecialchars($category) ?>">
        <input type="hidden" name="" id="ctotal" value="<?php echo htmlspecialchars($ctotal) ?>">

        <!--_______________________________________________________________________  -->

        <div class="pieChart">
          <h3>Expenses per Category</h3>
          <canvas id="myChart"></canvas>
        </div>

        <!--_______________________________________________________________________  -->

        <?php
        $select_user_method = mysqli_query($conn, "SELECT SUM(amount) as mtotal, method FROM expenses group by method;") or die('query failed');

        $method = '';
        $mtotal = '';

        // if the rows returned are more than 0, then:
        if(mysqli_num_rows($select_user_method) > 0){
          // Return an associative array of the user's data
          while($row = mysqli_fetch_assoc($select_user_method)){
            $method = $method.$row['method'].', ';
            $mtotal = $mtotal.$row['mtotal'].', ';
          }}

          // for testing only
          // echo $method;
          // echo $mtotal;
          ?>

          <input type="hidden" name="" id="method" value="<?php echo htmlspecialchars($method); ?>">
          <input type="hidden" name="" id="mtotal" value="<?php echo htmlspecialchars($mtotal); ?>">

          <!--_______________________________________________________________________  -->


          <div class="pieChart">
            <h3>Expenses per Payment Method</h3>
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
