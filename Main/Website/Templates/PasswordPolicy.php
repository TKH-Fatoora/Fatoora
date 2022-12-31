<?php

// Password Policy Function
function PasswordComply($mypass)
{
  global $message;

  if (strlen($mypass) >= 8)
  {
    // Search Rock you List
    if( !strpos(file_get_contents("./PasswordLists/rockyou.txt"),$mypass)) {
        // do stuff
        return true;
    }
    else
    {
      $message[] = "Password is Too Weak";
    }
  }else
  {
    $message[] = "Password is Too Short (8 Characters minimum)";
  }

    return false;
}

 ?>
