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


?>
<?php include 'Templates/notification.php' ?>
<?php include 'Templates/navbar.php' ?>

<!DOCTYPE html>
<html>
<head>
<title>HomePage</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>


body, html {
  height: 100%;
  line-height: 1.8;
  font-family: "Cairo", sans-serif;
}

/* Full height image header */
.bgimg-1 {
  background-position: center;
  background-size: cover;
  background-image: url("Images/bg.jpg");
  min-height: 100%;
}

.w3-bar .w3-button {
  padding: 16px;
}
</style>
</head>
<body>

<!-- Header with full-height image -->
<header class="bgimg-1 w3-display-container w3-grayscale-min" id="home">
  <div id="overlay"></div>
  <div class="w3-display-left w3-text-white" style="padding:48px">
    <span class="w3-jumbo w3-hide-small">The easiet way to manage personal financies</span><br>
    <span class="w3-xxlarge w3-hide-large w3-hide-medium">The easiet way to manage personal financies</span><br>
    <span class="w3-large">Fatoora, First Egyptian Money Manager</span>
    <p><a href="#about" class="w3-button w3-white w3-padding-large w3-large w3-margin-top w3-opacity w3-hover-opacity-off">Learn more and start today</a></p>
  </div>
</header>

<!-- About Section -->
<div class="w3-container" style="padding:128px 16px" id="about">
  <h3 class="w3-center">ABOUT THE COMPANY</h3>
  <p class="w3-center w3-large">Key features of our company</p>
  <div class="w3-row-padding w3-center" style="margin-top:64px">
    <div class="w3-quarter">
      <i class="fa fa-desktop w3-margin-bottom w3-jumbo w3-center"></i>
      <p class="w3-large">Easy Content Access</p>
      <p>Monthly total and budgets are provided.</p>
    </div>
    <div class="w3-quarter">
      <i class="fa fa-heart w3-margin-bottom w3-jumbo"></i>
      <p class="w3-large">Aesthetically Improved Charts</p>
      <p>Review your expenses with improved and well-organized pie charts.</p>
    </div>
    <div class="w3-quarter">
      <i class="fa fa-diamond w3-margin-bottom w3-jumbo"></i>
      <p class="w3-large">Reinforced Filter</p>
      <p>Review your transactions with more filtering options.</p>
    </div>
    <div class="w3-quarter">
      <i class="fa fa-cog w3-margin-bottom w3-jumbo"></i>
      <p class="w3-large">Easier Double-Entry Booking</p>
      <p>Manage your savings, insurance, loans and real-estate.</p>
    </div>
  </div>
</div>

<!-- Promo Section - "We know design" -->
<div class="w3-container w3-light-grey" style="padding:128px 16px">
  <div class="w3-row-padding">
    <div class="w3-col m6">
      <h3>Forget what you actually spend daily?</h3>
      <p>Fatoora is a money managing website, where the user inputs every purchase done throughout the day<br>by classifying where the money was actually deducted through a certain account such as a Debit Card or a Prepaid Account, and classifies their purchase under certain categories ranging from Health, Transportation, Beauty, or even Social Life..</p>
      <p><a href="expense.php" class="w3-button w3-black"><i class="fa fa-th"> </i> Start now and record your Spendings</a></p>
    </div>
    <div class="w3-col m6">
      <img class="w3-image w3-round-large" src="Images/lol.png" alt="View" width="700" height="394">
    </div>
  </div>
</div>

<!-- Promo Section "Statistics" -->
<div class="w3-container w3-row w3-center w3-dark-grey w3-padding-64">
  <div class="w3-quarter">
    <span class="w3-xxlarge">20M+</span>
    <br>Downloads
  </div>
  <div class="w3-quarter">
    <span class="w3-xxlarge">270K</span>
    <br>Reviews
  </div>
  <div class="w3-quarter">
    <span class="w3-xxlarge">5+</span>
    <br>Accounts Group
  </div>
  <div class="w3-quarter">
    <span class="w3-xxlarge">10+</span>
    <br>Category for Managing your Spendings
  </div>

</div>
<!-- Contact Section -->

</body>
</html>
<?php include 'Templates/footer.php' ?>
