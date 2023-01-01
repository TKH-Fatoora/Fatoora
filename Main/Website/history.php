<?php

include 'Templates/config.php';

// start session
session_start();

// prevent session hijacking
@include 'Templates/session_hijacking_prevention.php';

// fetching the value for the user id
$user_id = $_SESSION['user_id'];

// _____________________________________________________________________________

// if user id is not set, then:
if(!isset($user_id)){
  // log user out
   header('location:logout.php');
};

// fetching the value for the user account status
$blocked = $_SESSION['is_blocked'];

// if user id is blocked, then:
if($blocked == 1){
  // redirect user to blocked page
   header('location:blocked.php');
};
 ?>

<!-- _______________________________________________________________________ -->

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>History</title>
    <!-- css style sheet link -->
    <link rel="stylesheet" href="CSS/history_styles.css">
    <!-- set content's width according to current screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  </head>
  <body>
<!-- _______________________________________________________________________ -->

    <?php include 'Templates/navbar.php'; ?>
    <?php include 'Templates/notification.php'; ?>

<!-- _______________________________________________________________________ -->

    <section class="results">
      <h1>History</h1>
      <div class="container">

<!-- _______________________________________________________________________ -->

        <?php
        // select expenses for each different date from the expenses table for the current logged in user
        $select_user_expenses = mysqli_query($conn, "SELECT DISTINCT `date` FROM `expenses` WHERE UserID = '$user_id'") or die('query failed');

        // if the rows returned are more than 0, then:
        if(mysqli_num_rows($select_user_expenses) > 0){
          // Return an associative array of the user's data
           while($date = mysqli_fetch_assoc($select_user_expenses)){
         ?>
<!-- _______________________________________________________________________ -->

        <div class="box">
          <div class="name">
            <!-- in each "fatoora", print out the day's date -->
            <h2><?php echo $date['date']; ?></h2>
          </div>

<!-- _______________________________________________________________________ -->
          <!-- Table headings -->
          <table class="table">
            <thead class="tabletitle">
              <th>Expense Title</th>
              <th>Category</th>
              <th>Method</th>
              <th>Price</th>
            </thead>
<!-- _______________________________________________________________________ -->
            <?php

            // select expenses for the specified date
            $expense_date = $date["date"];
            $select_date_expenses = mysqli_query($conn, "SELECT * FROM `expenses` WHERE UserID = '$user_id' AND `date` = '$expense_date' ") or die('query failed');
            // store total as 0
            $subTotal = 0;

            // if the rows returned are more than 0, then:
            if(mysqli_num_rows($select_date_expenses) > 0){
              // Return an associative array of the user's data
               while($expense = mysqli_fetch_assoc($select_date_expenses)){
             ?>
<!-- _______________________________________________________________________ -->

            <!-- display each expense details titles in a row -->
            <tr class="rowitem">
              <td class="itemtext"><?php echo htmlspecialchars($expense['name']); ?></td>
              <td class="itemtext"><?php echo htmlspecialchars($expense['category']); ?></td>
              <td class="itemtext"><?php echo htmlspecialchars($expense['method']); ?></td>
              <td class="itemtext"><?php echo htmlspecialchars('$'.$expense['amount']); ?></td>
            </tr>

<!-- _______________________________________________________________________ -->

            <?php
            // calculate the subtotal for the "fatoora"
            $subTotal += $expense['amount'];
                }
              }
              ?>
<!-- _______________________________________________________________________ -->
            <!-- print out the subtotal for the "fatoora" -->
            <tr class="tabletitle">
              <td></td>
              <td></td>
              <td><h3>Total</h3></td>
              <td><h3><?php echo htmlspecialchars('$'.$subTotal); ?></h3></td>
            </tr>
          </table>
        </div>

<!-- _______________________________________________________________________ -->
        <?php
              }
          }else{ //if there were no expenses returned, print out the empty statement?>
              <p class="empty">No expenses yet!</p>
        <?php
          }
        ?>
<!-- _______________________________________________________________________ -->
      </div>
    </section>

    <?php include 'Templates/footer.php'; ?>

  </body>
</html>
