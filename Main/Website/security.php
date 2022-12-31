<?php
// connection to database
@include 'Templates/config.php';

// start security session
session_start();

// prevent session hijacking
@include 'Templates/session_hijacking_prevention.php';

// fetching the value for the employee id
$security_id = $_SESSION['security_id'];

// _____________________________________________________________________________

// if security id is not set, then:
if(!isset($security_id)){
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

// _____________________________________________________________________________

// if the block user button is pressed,
if(isset($_POST['block_user'])){
   // fetch the id of the selected user
   $uid = $_POST['UserID'];

   mysqli_query($conn, "UPDATE `users` SET  blocked = 1  WHERE UserID = '$uid'") or die('query failed');

   $message[] = 'User has been blocked!'; // store notification alert
   header('location:security.php'); //reloads the updated page
}
// _____________________________________________________________________________

// if the unblock user button is pressed,
if(isset($_POST['unblock_user'])){
   // fetch the id of the selected user
   $uid = $_POST['UserID'];

   mysqli_query($conn, "UPDATE `users` SET  blocked = 0  WHERE UserID = '$uid'") or die('query failed');

   $message[] = 'User has been unblocked!'; // store notification alert
   header('location:security.php'); //reloads the updated page
}
// _____________________________________________________________________________

if(isset($_POST['delete_alert'])){

   $alert_id = $_POST['AlertID'];

   mysqli_query($conn, "DELETE FROM `secalerts` WHERE AlertID = '$alert_id'") or die('query failed');
   $message[] = 'Alert has been deleted!'; // store notification message
   header('location:security.php'); //reloads the updated page
}
// _____________________________________________________________________________

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <title>Alerts</title>
    <!-- set content's width according to current screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- linking my fontawesome kit to be able to add icons  -->
    <script src="https://kit.fontawesome.com/51f1a2fdea.js" crossorigin="anonymous"></script>
    <!-- css style sheet link -->
    <link rel="stylesheet" href="CSS/security_styles.css">
  </head>

  <body>
    <?php @include 'Templates/employeeNav.php'; ?>

    <section class="alert">
     <h1 class="title">Alerts</h1>
     <div class="container">

<!-- _______________________________________________________________________ -->

      <?php
      // select all alerts in the alert table in the databse
      $select_alert = mysqli_query($conn, "SELECT * FROM `secalerts`") or die('query failed');

       // if more than zero rows were returned, loops over all alerts and stores them in an associative array
       if(mysqli_num_rows($select_alert) > 0){
          while($fetch_alert = mysqli_fetch_assoc($select_alert)){
      ?>

      <!-- Printing out each user's data and alert -->
      <div class="box">
        <?php
          $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE UserID = '{$fetch_alert['UserID']}'") or die('query failed');

          $Blocked = 0;
          // if the rows returned are more than 0, then:
          if(mysqli_num_rows($select_users) > 0){
            // Return an associative array of the user's data
             $user = mysqli_fetch_assoc($select_users);
             $Blocked = $user['blocked'];
             $type = $user['type'];
           }
          ?>
        <!-- htmlspecialchars prevents against xss attacks -->
        <p>Alert id: <span><?php echo htmlspecialchars($fetch_alert['AlertID']); ?></span></p>
        <p>User id: <span><?php echo htmlspecialchars($fetch_alert['UserID']); ?></span></p>
        <p>Category: <span><?php echo htmlspecialchars($fetch_alert['Category']); ?></span></p>
        <p>Severity: <span style="color:<?php if($fetch_alert['Severity'] == '1'){ echo '#00918b'; }elseif ($fetch_alert['Severity'] == '1'){ echo 'orange'; } else {echo 'red';} ?>"><b><?php echo htmlspecialchars($fetch_alert['Severity']); ?></b></span></p>
        <textarea class="content" disabled><?php echo htmlspecialchars($fetch_alert['Content']); ?></textarea>

        <form class="" action="security.php" method="post">
          <input type="hidden" name="UserID" value="<?php echo htmlspecialchars($fetch_alert['UserID']); ?>">
          <input type="hidden" name="AlertID" value="<?php echo htmlspecialchars($fetch_alert['AlertID']); ?>">
          <?php if($Blocked == 0 and $type !== "admin"){ ?>
          <input type="submit" class="btn" value="Block User" name="block_user">
        <?php }elseif($Blocked == 1 and $type !== "admin"){ ?>
          <input type="submit" class="btn" value="Unblock User" name="unblock_user">
          <?php } ?>
          <input type="submit" class="btn" value="Delete Alert" name="delete_alert">
        </form>
      </div>
<!-- _______________________________________________________________________ -->
      <?php
         }
      }else{ //if there were no alerts returned, print out the empty statement
         echo '<p class="empty">You have no alerts!</p>';
      }
      ?>
<!-- _______________________________________________________________________ -->
     </div>
    </section>

  </body>
</html>
