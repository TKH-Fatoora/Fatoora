<?php

function Hacking_Detected($Reason,$SOCmsg)
{
  // Submit Reason to SOC DB
  $_SESSION["HACK"] = $Reason;
  header('location:Hacking_Detected.php');
}
 ?>
