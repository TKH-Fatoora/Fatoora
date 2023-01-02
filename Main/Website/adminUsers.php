<?php
// connection to databse
@include 'Templates/config.php';

// Hacking Detected Template
include 'Templates/HackingDetectedTemp.php';
// start admin session
session_start();

// _____________________________________________________________________________

// prevent session hijacking
@include 'Templates/session_hijacking_prevention.php';
//Reset the variable
if(isset($_SESSION['selected_user_id'])) { unset($_SESSION['selected_user_id']); }

// fetching the value for the admin id
$admin_id = $_SESSION['admin_id'];

// _____________________________________________________________________________

// if admin id is not set, then:
if(!isset($admin_id)){
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
  Hacking_Detected("Insufficent Access",$alertuserID,"Unauthorized Access to Admin Users pasge Was Attempted","Insufficent Access",2);
  // redirect user to log in again
   header('location:logout.php');
}


  // _____________________________________________________________________________

  // if the update user button is pressed,
  if(isset($_POST['update_user'])){

    // Check For CSRF Token
    if (
      isset($_POST["csrf"]) &&             // Check For CSRF Token From the Form
      isset($_SESSION["csrf"]) &&          // Check For CSRF Token From the Session
      isset($_SESSION["csrf-expire"]) &&   // Check For CSRF Token Expiration From the Session
      $_SESSION["csrf"]==$_POST["csrf"]    // Check IF CLient Token Matches Server Stored Token
    ) {
      // If CSRF token EXPIRED
      if (time() >= $_SESSION["csrf-expire"]) {
        // Exit and Set Notification Token expired
        $message[] = "Session expired. Please Log in Again.";
        // Log User Out
        header('location:logout.php');
      }
    }else
      {
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
        Hacking_Detected("Insufficent Access",$alertuserID,"No CSRF Token in Use to Access page: Admin Users ","Insufficent Access",3);
      }

     // fetch the id of the selected user
     $update_id = $_POST['userID'];
     // Get User Type
     $type = mysqli_real_escape_string($conn, $_POST['type']);
     // update the selected user's privilege from the users table in the database
     mysqli_query($conn, "UPDATE `users` SET type = '$type' WHERE UserID = '$update_id'") or die('query failed');
     $message[] = 'User has been deleted!'; // store notification message
  }
  // _____________________________________________________________________________
  // if the delete user button is pressed,
  if(isset($_POST['delete_user'])){
     // fetch the id of the selected user
     $delete_id = $_POST['userID'];
     // delete the selected user from the users,expenses,messages tables in the database
     mysqli_query($conn, "DELETE FROM `users` WHERE UserID = '$delete_id'") or die('query failed');
     mysqli_query($conn, "DELETE FROM `expenses` WHERE UserID = '$delete_id'") or die('query failed');
     mysqli_query($conn, "DELETE FROM `message` WHERE UserID = '$delete_id'") or die('query failed');
     $message[] = 'User has been deleted!'; // store notification message
  }

  // _____________________________________________________________________________
  // if the delete user button is pressed,
  if(isset($_POST['stats_user'])){
     // fetch the id of the selected user
     $_SESSION['selected_user_id'] = $_POST['userID'];

     header('location:adminStatsPerUser.php'); //reloads the updated page
  }

// _____________________________________________________________________________

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <title>Users</title>
    <!-- set content's width according to current screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- linking my fontawesome kit to be able to add icons  -->
    <script src="https://kit.fontawesome.com/51f1a2fdea.js" crossorigin="anonymous"></script>
    <!-- css style sheet link -->
    <link rel="stylesheet" href="CSS/adminUsers_styles.css">
  </head>

  <body>
    <?php @include 'Templates/adminNav.php'; ?>

    <section class="users">
     <h1 class="title">Users Accounts</h1>
     <div class="container">

<!-- _______________________________________________________________________ -->

      <?php
       // select all users in the users table in the databse
       $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
       // if more than zero rows were returned, loops over all messages and stores them in an associative array
       if(mysqli_num_rows($select_users) > 0){
         // Loop over Users
          while($fetch_users = mysqli_fetch_assoc($select_users)){
      ?>

<!-- _______________________________________________________________________ -->

      <!-- Printing out each user's data and user type -->
      <div class="box">
        <!-- htmlspecialchars prevents against xss attacks -->
         <p>User id: <span><?php echo htmlspecialchars($fetch_users['UserID']); ?></span></p>
         <p>Username: <span><?php echo htmlspecialchars($fetch_users['name']); ?></span></p>
         <p>Email: <span><?php echo htmlspecialchars($fetch_users['email']); ?></span></p>
         <form class="" action="adminUsers.php" method="post" enctype="multipart/form-data">
           <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION["csrf"]);?>">
           <span class="sub">User Type:</span>
           <select class="type" name="type" required>
             <option value="user" <?php if ($fetch_users['type'] == 'user' ){?> selected <?php  }?> > user </option>
             <option value="employee" <?php if ($fetch_users['type'] == 'employee' ){?> selected <?php  }?> > employee </option>
             <option value="security" <?php if ($fetch_users['type'] == 'security' ){?> selected <?php  }?> > security </option>
             <option value="admin" <?php if ($fetch_users['type'] == 'admin' ){?> selected <?php  }?> > admin </option>
           </select>
           <input type="hidden" name="userID" value="<?php echo htmlspecialchars($fetch_users['UserID']); ?>">
           <input type="submit" class="btn" value="Update" name="update_user">
           <br><input type="submit" class="dlt-btn" value="Delete" name="delete_user">
           <input type="submit" class="btn" value="Statistics" name="stats_user">
         </form>
      </div>

<!-- _______________________________________________________________________ -->
      <!-- While Loop End -->
      <?php
         }
      }
      ?>
     </div>
    </section>
  </body>
</html>
