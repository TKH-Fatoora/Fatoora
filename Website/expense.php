<?php
include 'Templates/navbar.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/expensestyles.css">
    <title>Expense</title>
  </head>
  <body>
    <section class="add">

      <!-- add new Expense -->
      <form class="expenses" action="" method="post" enctype="multipart/form-data">
        <h3>New Expense</h3>

        <!-- date -->
        <input type="date" name="date" class="box">

        <!-- payment method -->
        <select class="method" name="method" required>
          <option value="" selected disabled>Payment Method</option>
          <option value="cash">Cash</option>
          <option value="credit">Credit</option>
          <option value="debit">Debit</option>
          <option value="prepaid">Pre-paid</option>
          <option value="other">other</option>
        </select>

        <!-- category -->
        <select class="category" name="category" required>
          <option value="" selected disabled>Category</option>
          <option value="food">Food</option>
          <option value="transportation">Transportation</option>
          <option value="shopping">Shopping</option>
          <option value="entertainment">Entertainment</option>
          <option value="health">Health</option>
          <option value="coffee">Coffee</option>
          <option value="selfdevelopment">Self-Development</option>
          <option value="other">other</option>
        </select>

        <!-- note-->
        <input type="text" name="name" class="box" required placeholder="Please enter expense title">

        <!-- ammount -->
        <input type="number" name="amount" class="box" min="0" required placeholder="Please enter price">

        <!-- description field-->
        <textarea name="note" class="box" cols="30" rows="10" placeholder="Please enter note"></textarea>

        <!-- image field-->
        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">

        <!-- add product button -->
        <input type="submit" name="addExpense" class="btn" value="Add Expense">
      </form>
    </section>
  </body>
</html>
<?php
include 'Templates/footer.php';
?>
