<?php

// Password Policy Function
function PasswordComply($mypass)
{
  // Global Refrence to the notification List
  global $message;

  // Check if Passoword is More than or equal 8 characters
  if (strlen($mypass) >= 8)
  {
    // Search Rock you List for the Passoword
    if( !strpos(file_get_contents("./PasswordLists/rockyou.txt"),$mypass)) {
        // If Password not found Return true Meanning that The password Does Comply 
        return true;
    }
    else
    {
      // If Password not found Return a notification
      $message[] = "Password is Too Weak";
    }
  }else
  {
    // If Password not of length Return a notification
    $message[] = "Password is Too Short (8 Characters minimum)";
  }
    // If True not returned return False Meanning that The password Does not Comply
    return false;
}

 ?>
