<?php
// connection to databse
@include 'Templates/config.php';

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

// _____________________________________________________________________________

// A function to filter the images file name
function filter_filename($fname) {
    // remove illegal file system characters https://en.wikipedia.org/wiki/Filename#Reserved_characters_and_words
    return str_replace(array_merge( array_map('chr', range(0, 31)), array('<', '>', ':', '"', '/', '\\', '|', '?', '*')), '', $fname);
}

// _____________________________________________________________________________

// check CSRF token
if (
  isset($_POST["csrf"]) &&            // Check for CSRF token from the form
  isset($_SESSION["csrf"]) &&         // Check for CSRF token from the session
  isset($_SESSION["csrf-expire"]) &&  // Check for CSRF token expiration from the session
  $_SESSION["csrf"]==$_POST["csrf"]   // Check if client token matches server stored token
) {
  // if CSRF token has expired, log the user out
  if (time() >= $_SESSION["csrf-expire"]) {
    exit("csrf expired. Please reload form.");
    header('location:logout.php');
  }

// _____________________________________________________________________________

  // if the add product button is pressed,
  if(isset($_POST['addExpense'])){
    // The FILTER_SANITIZE_STRING filter removes tags and remove or encode special characters from a string.
     //  mysqli_real_escape_string() function escapes special characters in a string and prevents against sql attacks

     // fetch the date, method, category, name, amount & note of the selected product
     $date = mysqli_real_escape_string($conn, $_POST['date']);
     $method = mysqli_real_escape_string($conn, filter_var($_POST['method'], FILTER_SANITIZE_STRING));
     $category = mysqli_real_escape_string($conn, filter_var($_POST['category'], FILTER_SANITIZE_STRING));
     $name = mysqli_real_escape_string($conn, filter_var($_POST['name'], FILTER_SANITIZE_STRING));
     $amount = mysqli_real_escape_string($conn, filter_var($_POST['amount'], FILTER_SANITIZE_STRING));
     $note = mysqli_real_escape_string($conn, filter_var($_POST['note'], FILTER_SANITIZE_STRING));

// _____________________________________________________________________________
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
       $filteredName = filter_filename($name) . '.' . end($temp);
       //store image size
       $image_size = $_FILES['image']['size'];
     }else {
       $filteredName = 'none.jpg';
     }

 // ____________________________________________________________________________

     // insert the expense data into the database
      $insert_expense = mysqli_query($conn, "INSERT INTO `expenses`(UserID, `date`, method, category, name, amount, note, image) VALUES('$user_id', '$date', '$method', '$category','$name', '$amount', '$note', '$filteredName')") or die('query failed');

// _____________________________________________________________________________

    // image size validation
     if(!empty($_FILES["image"]["name"]))
     {
       if($image_size > 6000000){                 //validate image size (6mb images)
         $message[] = 'image size is too large!'; // store notification message
       }else{
         // if image is less than 6mb, store it in the images folder
         if(!empty($_FILES["image"]["name"])) move_uploaded_file($_FILES["image"]["tmp_name"], $target . $filteredName);
         $message[] = 'expense added successfully!'; // store notification message
       }
     }
  }
}
?>
<!-- _______________________________________________________________________ -->

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/expense_styles.css">
    <title>Expense</title>
    <!-- set content's width according to current screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  </head>

<!-- _______________________________________________________________________ -->

  <body>
    <?php include 'Templates/notification.php' ?>
    <?php include 'Templates/navbar.php';?>

<!-- _______________________________________________________________________ -->

    <!-- add new Expense -->
    <section class="add">
      <form class="expenses" action="expense.php" method="POST" enctype="multipart/form-data">
        <h3>New Expense</h3>
        <!-- CSRF token -->
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION["csrf"]);?>">

        <!-- input date -->
        <input type="date" name="date" class="box">

        <!-- payment method drop down list -->
        <select class="method" name="method" required>
          <option value="" selected disabled>Payment Method</option>
          <option value="cash">Cash</option>
          <option value="credit">Credit</option>
          <option value="debit">Debit</option>
          <option value="prepaid">Pre-paid</option>
          <option value="other">other</option>
        </select>

        <!-- category drop down list-->
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

        <!-- ammount of expense-->
        <input type="number" step="0.01" name="amount" class="box" min="0" required placeholder="Please enter price">

        <!-- description field-->
        <textarea name="note" class="box" cols="30" rows="10" placeholder="Please enter note"></textarea>

        <!-- image field-->
        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">

<!-- _______________________________________________________________________ -->

        <!-- add expense button -->
        <input type="submit" name="addExpense" class="btn" value="Add Expense">

      </form>
    </section>
  </body>
</html>

<!-- _______________________________________________________________________ -->

<?php include 'Templates/footer.php'; ?>
