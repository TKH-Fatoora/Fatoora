<?php
// connection to databse
@include 'Templates/config.php';

// start user session
session_start();

// fetching the value for the user id
$user_id = $_SESSION['user_id'];

// _____________________________________________________________________________

// if user id is not set, then:
if(!isset($user_id)){
  // redirect user to log in again
   header('location:login.php');
};

// _____________________________________________________________________________


// of the send button is pressed,
if(isset($_POST['submit'])){
    // mysqli_real_escape_string() function escapes special characters in a string and prevents against sql attacks

    // fetch the name, email, number & message content of the user
    $email = mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_STRING));
    $subject = mysqli_real_escape_string($conn, filter_var($_POST['subject'], FILTER_SANITIZE_STRING));
    $content = mysqli_real_escape_string($conn, filter_var($_POST['message'], FILTER_SANITIZE_STRING));

// _____________________________________________________________________________
    // check if a message with the same user info and content already exists in the message table in the database
    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE email = '$email' AND subject = '$subject' AND content = '$content'") or die('query failed');

    // if more than 0 rows were returned, then the message already exists
    if(mysqli_num_rows($select_message) > 0){
      $message[] = 'Message sent already!'; // store notification message

    }else{
      // insert new message in the message table in the databse
      mysqli_query($conn, "INSERT INTO `message`(UserID, email, subject,  content) VALUES('$user_id', '$email', '$subject', '$content')") or die('query failed');
      $message[] = 'Message sent successfully!'; // store notification message
    }
}
?>

<!-- _______________________________________________________________________ -->

<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>

      <meta charset="utf-8">
      <title>Contact Us</title>
      <link rel="stylesheet"  href="CSS/contact_us.css">

  </head>
  <body>

<!-- _______________________________________________________________________ -->

    <?php include 'Templates/notification.php' ?>
    <?php include 'Templates/navbar.php';?>

<!-- _______________________________________________________________________ -->

      <div class="form_template">

        <h1 id="page_title">Contact us</h1>

          <form action="contact_us.php" method="POST">
              <label>Email:</label>
              <input type="email" id="email" name="email" required>

              <label>Subject</label>
              <input type="text" id="subject" name="subject" required>

              <label>Message:</label>
              <textarea required id="message" name="message" cols="30" rows="10"></textarea>

              <input type="submit" name="submit" value="Submit">
          </form>
      </div>

<!-- _______________________________________________________________________ -->

      <?php include 'Templates/footer.php';?>

<!-- _______________________________________________________________________ -->
  </body>
</html>
