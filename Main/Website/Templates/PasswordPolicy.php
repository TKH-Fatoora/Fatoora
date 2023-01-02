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

        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $mypass);
        $lowercase = preg_match('@[a-z]@', $mypass);
        $number    = preg_match('@[0-9]@', $mypass);
        $specialChars = preg_match('@[^\w]@', $mypass);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($mypass) < 8) {
          // Return True if passowrd is strong enough
          return true;
        }else{
          // If Password not of length Return a notification
          $message[] = "Password Must be a combination of upper and lower case charcter in addition to numbers and a special charcter";
        }


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
