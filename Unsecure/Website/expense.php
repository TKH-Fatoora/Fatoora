<?php
// connection to databse
@include 'Templates/config.php';
//
// start session
session_start();

// fetching the value for the user id
$user_id = $_SESSION['user_id'];

// _____________________________________________________________________________

// if the add product button is pressed,
if(isset($_POST['addExpense'])){

   // fetch the id, name, price, details, category & image of the selected product
   $date =  $_POST['date'];
   $method = $_POST['method'];
   $category = $_POST['category'];
   $name = $_POST['name'];
   $amount = $_POST['amount'];
   $note = $_POST['note'];

   // __________________________________________________________________________
   // Image Grabbing and Changing the filename
   if(!empty($_FILES["image"]["name"]))
   {
     // images Folder path
     $target = './images/';
     // Getting the image Name
     $filteredName = $_FILES["image"]["name"];
     // seperating the extension from the temporary file name
     $temp = explode(".", $_FILES["image"]["name"]);
     // renaming the Image
     $filteredName = $name . '.' . end($temp);

   }else {
     $filteredName = 'none.jpg';
   }

   // __________________________________________________________________________

   // if the product did not exist, insert all its data into the products table in the database
    $insert_expense = mysqli_query($conn, "INSERT INTO `expenses`(UserID, `date`, method, category, name, amount, note, image) VALUES('$user_id', '$date', '$method', '$category','$name', '$amount', '$note', '$filteredName')") or die('query failed');
 // __________________________________________________________________________

}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/expense_styles.css">
    <title>Expense</title>
  </head>
  <body>

    <?php include 'Templates/notification.php' ?>
    <?php include 'Templates/navbar.php';?>

    <section class="add">

      <!-- add new Expense -->
      <form class="expenses" action="expense.php" method="POST" enctype="multipart/form-data">
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

        <!-- name of expense-->
        <input type="text" name="name" class="box" required placeholder="Please enter expense title">

        <!-- ammount -->
        <input type="number" step="0.01" name="amount" class="box" min="0" required placeholder="Please enter price">

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
