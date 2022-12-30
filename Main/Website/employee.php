<?php
// connection to database
@include 'Templates/config.php';

// start employee session
session_start();

// prevent session hijacking
@include 'Templates/session_hijacking_prevention.php';

// fetching the value for the employee id
$employee_id = $_SESSION['employee_id'];

// _____________________________________________________________________________

// if employee id is not set, then:
if(!isset($employee_id)){
  // redirect user to log in again
   header('location:login.php');
};

// _____________________________________________________________________________

// if the delete user button is pressed,
if(isset($_POST['delete_message'])){
   // fetch the id of the selected user
   $delete_id = $_POST['MessageID'];
   // delete the selected user from the users table in the database
   mysqli_query($conn, "DELETE FROM `message` WHERE MessageID = '$delete_id'") or die('query failed');
   $message[] = 'Message has been deleted!'; // store notification message
   header('location:employee.php'); //reloads the updated page
}
// _____________________________________________________________________________
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <title>Inquiries</title>
    <!-- set content's width according to current screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- linking my fontawesome kit to be able to add icons  -->
    <script src="https://kit.fontawesome.com/51f1a2fdea.js" crossorigin="anonymous"></script>
    <!-- css style sheet link -->
    <link rel="stylesheet" href="CSS/employee_styles.css">
  </head>

  <body>
    <?php @include 'Templates/employeeNav.php'; ?>

    <section class="messages">
     <h1 class="title">Messages</h1>
     <div class="container">

<!-- _______________________________________________________________________ -->

      <?php
      // select all messages in the message table in the databse
      $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');

       // if more than zero rows were returned, loops over all messages and stores them in an associative array
       if(mysqli_num_rows($select_message) > 0){
          while($fetch_message = mysqli_fetch_assoc($select_message)){
      ?>

      <!-- Printing out each user's data and message -->
      <div class="box">
        <!-- htmlspecialchars prevents against xss attacks -->
        <p>User id: <span><?php echo htmlspecialchars($fetch_message['UserID']); ?></span></p>
        <p>Email: <span><?php echo htmlspecialchars($fetch_message['email']); ?></span></p>
        <p>Subject: <span><b><?php echo htmlspecialchars($fetch_message['subject']); ?></b></span></p>
        <textarea class="content"><?php echo htmlspecialchars($fetch_message['content']); ?></textarea>

        <form class="" action="employee.php" method="post">
          <input type="hidden" name="MessageID" value="<?php echo htmlspecialchars($fetch_message['MessageID']); ?>">
          <input type="submit" class="btn" value="Delete" name="delete_message">
        </form>
      </div>
<!-- _______________________________________________________________________ -->
      <?php
         }
      }else{ //if there were no messages returned, print out the empty statement
         echo '<p class="empty">You have no messages!</p>';
      }
      ?>
<!-- _______________________________________________________________________ -->
     </div>
    </section>

  </body>
</html>
