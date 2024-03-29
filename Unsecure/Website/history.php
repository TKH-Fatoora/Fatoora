<?php

include 'Templates/config.php';

// start session
session_start();

// fetching the value for the user id
$user_id = $_SESSION['user_id'];

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/history_styles.css">
    <title>History</title>
  </head>
  <body>

    <?php include 'Templates/navbar.php'; ?>
    <?php include 'Templates/notification.php'; ?>

<!-- _______________________________________________________________________ -->

    <section class="results">
      <h1>History</h1>
      <div class="container">

<!-- _______________________________________________________________________ -->

        <?php
        $select_user_expenses = mysqli_query($conn, "SELECT DISTINCT `date` FROM `expenses` WHERE UserID = '$user_id'") or die('query failed');

        // if the rows returned are more than 0, then:
        if(mysqli_num_rows($select_user_expenses) > 0){
          // Return an associative array of the user's data
           while($date = mysqli_fetch_assoc($select_user_expenses)){
         ?>
<!-- _______________________________________________________________________ -->

        <div class="box">
          <div class="name">
            <h2><?php echo $date['date']; ?></h2>
          </div>

          <table class="table">
            <thead class="tabletitle">
              <th>Expense Title</th>
              <th>Category</th>
              <th>Method</th>
              <th>Price</th>
            </thead>
<!-- _______________________________________________________________________ -->
            <?php
            $expense_date = $date["date"];
            $select_date_expenses = mysqli_query($conn, "SELECT * FROM `expenses` WHERE UserID = '$user_id' AND `date` = '$expense_date' ") or die('query failed');

            $subTotal = 0;


            // if the rows returned are more than 0, then:
            if(mysqli_num_rows($select_date_expenses) > 0){
              // Return an associative array of the user's data
               while($expense = mysqli_fetch_assoc($select_date_expenses)){
             ?>
<!-- _______________________________________________________________________ -->
            <tr class="rowitem">
              <td class="itemtext"><?php echo $expense['name']; ?></td>
              <td class="itemtext"><?php echo $expense['category']; ?></td>
              <td class="itemtext"><?php echo $expense['method']; ?></td>
              <td class="itemtext"><?php echo '$'.$expense['amount']; ?></td>
            </tr>

<!-- _______________________________________________________________________ -->
            <?php
            $subTotal += $expense['amount'];
                }
              }
              ?>
<!-- _______________________________________________________________________ -->
            <tr class="tabletitle">
              <td></td>
              <td></td>
              <td><h3>Total</h3></td>
              <td><h3><?php echo '$'.$subTotal; ?></h3></td>
            </tr>
          </table>
        </div>

<!-- _______________________________________________________________________ -->
        <?php
              }
          }else{ //if there were no orders returned, print out the empty statement?>
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
