<?php

include 'HackingDetectedTemp.php';

if (isset($_SESSION["UID"]))
{
  $uid = $_SESSION["UID"];
}
else
{
  $uid = 0;
}

// Does IP Address match?
if ($_SERVER['REMOTE_ADDR'] != $_SESSION['ipaddress'])
{
  // if not, unset and destroy the user's session
  session_unset();
  session_destroy();
  Hacking_Detected("Session Hijacking",$uid,"Session Hijacking Was Detected","Session Hijacking : IP Addr",3);
}

// Does user agent match?
if ($_SERVER['HTTP_USER_AGENT'] != $_SESSION['useragent'])
{
  // if not, unset and destroy the user's session
  session_unset();
  session_destroy();
  Hacking_Detected("Session Hijacking",$uid,"Session Hijacking Was Detected","Session Hijacking : USER AGENT",3);
}

// Is the last access over an hour ago?
if (time() > ($_SESSION['lastaccess'] + 3600))
{
  // if not, unset and destroy the user's session
  session_unset();
  session_destroy();
  Hacking_Detected("Session Hijacking",$uid,"Session Hijacking Was Detected","Session Hijacking : Last Access",3);
}
else
{
  // store last access time
  $_SESSION['lastaccess'] = time();
}
?>
