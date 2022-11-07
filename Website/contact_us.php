<?php
include 'Templates/config.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Contact Us</title>
    <link rel="stylesheet"  href="CSS/contact_us.css">
</head>

<body>
  <?php include 'Templates/navbar.php';?>
    <div>
    <h1 id="page_title">Contact us</h1>
    <hr class="horizon_line">
    </div>

    <div class="form_template">
        <form>

            <label>Name:</label>
            <input type="text" id="name" name="name">

            <label>Email:</label>
            <input type="text" id="email" name="email">

            <label>Subject</label>
            <input type="text" id="subject" name="subject">

            <label>Message:</label>
            <textarea id="message" name="message"></textarea>

            <input type="submit" value="Submit">
        </form>
    </div>
    <?php include 'Templates/footer.php';?>
</body>

</html>
