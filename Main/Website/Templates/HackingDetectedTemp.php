<?php
// Reuseable Function to Isolate Attacker and Send an Alert
function Hacking_Detected($Usermsg,$UserID,$AlertContent,$Category,$Severity)
{
  // Include the Database Configuration File
  @include 'Templates/config.php';

  // Stora an Alert to the SecAlerts Table in the Database
  mysqli_query($conn, "INSERT INTO `secalerts`(UserID, content, Category, Severity) VALUES('$UserID','$AlertContent','$Category','$Severity')") or die('query failed');

  // Set Session Variable HACK to the supplied alert
  $_SESSION["HACK"] = $Usermsg;
  
  // Head to the Hacking detetced page
  header('location:Hacking_Detected.php');
}
 ?>
