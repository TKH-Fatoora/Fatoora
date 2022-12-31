<?php
include_once(__DIR__.'/../vendor/autoload.php');

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function SendEmail($RecepientEmail,$RecepientName,$eContent)
{
  //Create an instance; passing `true` enables exceptions
  $mail = new PHPMailer(true);
  try
  {
      //Server settings
      $mail->SMTPDebug = 0;                        //Enable verbose debug output
      $mail->isSMTP();                             //Send using SMTP
      $mail->Host       = 'smtp.gmail.com';        //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                    //Enable SMTP authentication
      $mail->Username   = 'gogo47face@gmail.com';  //SMTP username
      $mail->Password   = 'dzdzieqvwydmijtg';      //SMTP password
      $mail->SMTPSecure = 'tls';                   //Enable implicit TLS encryption
      $mail->Port       = 587;                     //TCP port to connect to;

      //Recipients
      $mail->setFrom('TKHFatoora@gmail.com', 'Fatoora');
      $mail->addAddress($RecepientEmail, $RecepientName);  //Add a recipient
      //Content
      $mail->isHTML(true);                         //Set email format to HTML
      $mail->Subject = 'Account Verification';
      $mail->Body    = $eContent;

      $mail->send();
      $message[] = 'Email has been sent';
    }
    catch (Exception $e)
    {
      // Error Handle for Debugging
      $message[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

 ?>
