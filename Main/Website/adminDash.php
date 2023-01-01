<?php
// connection to databse
@include 'Templates/config.php';

// start admin session
session_start();

// prevent session hijacking
@include 'Templates/session_hijacking_prevention.php';

// fetching the value for the admin id
$admin_id = $_SESSION['admin_id'];

// _____________________________________________________________________________

// if admin id is not set, then:
if(!isset($admin_id)){
  // log user out
   header('location:logout.php');
};

 ?>

<!-- _______________________________________________________________________ -->

<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <!-- css style sheet link -->
    <link rel="stylesheet" href="CSS/adminDash_styles.css">
    <!-- set content's width according to current screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- linking fontawesome kit to be able to add icons  -->
    <script src="https://kit.fontawesome.com/51f1a2fdea.js" crossorigin="anonymous"></script>
  </head>

<!-- _______________________________________________________________________ -->

  <body>
    <?php @include 'Templates/adminNav.php'; ?>

    <section class="dboard">
      <h1 class="title">Dashboard</h1>
      <div class="container">
<!-- _______________________________________________________________________ -->
        <!-- Number of user accounts -->
        <div class="box">
           <?php
            // select all users that have a user account type in the users table in the databse
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE type = 'user'") or die('query failed');
            // counts the number of rows returned ==> number of user accounts
            $number_of_users = mysqli_num_rows($select_users);
           ?>
           <!-- print out the number of user accounts -->
           <h3><?php echo htmlspecialchars($number_of_users); ?></h3> <!-- htmlspecialchars prevents against xss attacks -->
           <p>Customer Users</p>
        </div>
<!-- _______________________________________________________________________ -->
        <!-- Number of Employee accounts -->
        <div class="box">
           <?php
            // select all users that have an employee account type in the users table in the databse
            $select_employee = mysqli_query($conn, "SELECT * FROM `users` WHERE type = 'employee'") or die('query failed');
            // counts the number of rows returned ==> number of employee accounts
            $number_of_employee = mysqli_num_rows($select_employee);
           ?>
           <!-- print out the number of employee accounts -->
           <h3><?php echo htmlspecialchars($number_of_employee); ?></h3> <!-- htmlspecialchars prevents against xss attacks -->
           <p>Employee Users</p>
        </div>
<!-- _______________________________________________________________________ -->
        <!-- Number of Security admin accounts -->
        <div class="box">
           <?php
            // select all users that have a security account type in the users table in the databse
            $select_security = mysqli_query($conn, "SELECT * FROM `users` WHERE type = 'security'") or die('query failed');
            // counts the number of rows returned ==> number of security admin accounts
            $number_of_security = mysqli_num_rows($select_security);
           ?>
           <!-- print out the number of security admin accounts -->
           <h3><?php echo htmlspecialchars($number_of_security); ?></h3> <!-- htmlspecialchars prevents against xss attacks -->
           <p>Security Admin Users</p>
        </div>
<!-- _______________________________________________________________________ -->
        <!-- Number of admin accounts -->
        <div class="box">
           <?php
            // select all users that have an admin account type in the users table in the databse
            $select_admin = mysqli_query($conn, "SELECT * FROM `users` WHERE type = 'admin'") or die('query failed');
            // counts the number of rows returned ==> number of admin accounts
            $number_of_admin = mysqli_num_rows($select_admin);
           ?>
           <!-- print out the number of admin accounts -->
           <h3><?php echo htmlspecialchars($number_of_admin); ?></h3> <!-- htmlspecialchars prevents against xss attacks -->
           <p>Admin Users</p>
        </div>
<!-- _______________________________________________________________________ -->
        <!-- Total number of accounts -->
        <div class="box">
           <?php
            // select all users in the users table in the databse
            $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            // counts the number of rows returned ==> total number of accounts
            $number_of_account = mysqli_num_rows($select_account);
           ?>
           <!-- print out the total number of accounts -->
           <h3><?php echo htmlspecialchars($number_of_account); ?></h3> <!-- htmlspecialchars prevents against xss attacks -->
           <p>Total Accounts</p>
        </div>
<!-- _______________________________________________________________________ -->
        <!-- Total number of messages -->
        <div class="box">
           <?php
            // select all messages in the message table in the databse
            $select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
            // count number of rows returned ==> total messages recieved
            $number_of_messages = mysqli_num_rows($select_messages);
           ?>
           <!-- print out the total number of messages -->
           <h3><?php echo htmlspecialchars($number_of_messages); ?></h3> <!-- htmlspecialchars prevents against xss attacks -->
           <p>Messages</p>
        </div>
<!-- _______________________________________________________________________ -->
        <!-- Total number of Alerts -->
        <div class="box">
           <?php
            // select all alerts in the secalerts table in the databse
            $select_alerts = mysqli_query($conn, "SELECT * FROM `secalerts`") or die('query failed');
            // count number of rows returned ==> total alerts recieved
            $number_of_alerts = mysqli_num_rows($select_alerts);
           ?>
           <!-- print out the total number of alerts -->
           <h3><?php echo htmlspecialchars($number_of_alerts); ?></h3> <!-- htmlspecialchars prevents against xss attacks -->
           <p>Security Alerts</p>
        </div>
<!-- _______________________________________________________________________ -->
      </div>
    </section>

    <!-- linking the JavaScript file -->
    <script src="Scripts/nav.js"></script>
  </body>
</html>
