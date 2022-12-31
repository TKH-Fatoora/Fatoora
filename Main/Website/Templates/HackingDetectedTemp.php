<?php
function Hacking_Detected($Usermsg,$UserID,$AlertContent,$Category,$Severity)
{
  @include 'Templates/config.php';
  // Submit Reason to SOC DB
  mysqli_query($conn, "INSERT INTO `secalerts`(UserID, content, Category, Severity) VALUES('$UserID','$AlertContent','$Category','$Severity')") or die('query failed');
  $_SESSION["HACK"] = $Usermsg;
  header('location:Hacking_Detected.php');
}
 ?>
