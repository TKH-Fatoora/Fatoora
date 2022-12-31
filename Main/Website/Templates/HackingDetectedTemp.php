<?php

function Hacking_Detected($Usermsg,$SOCmsg)
{
  // Submit Reason to SOC DB
  $_SESSION["HACK"] = $Usermsg;
  header('location:Hacking_Detected.php');
}
 ?>
