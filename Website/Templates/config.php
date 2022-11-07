<?php
// Begin Session
session_start();

// MYSQLI Server Connection Variables
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "GameSpot";

// Connection Statment to mysqli Server
$dbc = mysqli_connect($hostname, $username, $password, $dbname) OR die("Couldnt connect to DB" . mysqli_connect_error());
// Setting the Charchter Set
mysqli_set_charset($dbc,"utf8");

// The Path to the Images Folder
$imagesPath = "../images/";

// Creating the Session Notifications Variable
if (!isset($_SESSION["Notifications"])) $_SESSION["Notifications"] = [];

// Retriving the Notifications from the Session to a local array
$Notifications = $_SESSION["Notifications"];


// A function to add notifications to the session
function notify($Message){
  global $Notifications;                        // refrence to the notifications global variable
  array_push($Notifications,$Message);          // pushing the new message to the Notifications Array
  $_SESSION["Notifications"] = $Notifications;  // Update the Session Notifications with the local Array
}


// A function to remove notifications from the session
function DelNotify()
{
  global $Notifications;                      // refrence to the notifications global variable
  array_pop($Notifications);                  // removing the last message from the Notifications Array
  $_SESSION["Notifications"] = $Notifications;// Update the Session Notifications with the local Array

}

// Retreive the current number of items when logged in
if(isset($_SESSION['UID']))
{
  // Storing the Current UID
  $UID = $_SESSION['UID'];

  // Store the number of rows of the selection query for wishlist, cart, and pending orders that belong to the user
  $wishlistCount = mysqli_num_rows(mysqli_query($dbc, "SELECT * FROM wishlist WHERE UID = $UID "));
  $cartlistCount = mysqli_num_rows(mysqli_query($dbc, "SELECT * FROM cartitems WHERE UID = $UID "));
  $pendingOrderCount = mysqli_num_rows(mysqli_query($dbc, "SELECT * FROM orders WHERE UID = $UID and status = 'Pending' "));
}

 ?>
