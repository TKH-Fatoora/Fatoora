
<!-- css style sheet link -->
<link rel="stylesheet" href="CSS/notification.css">


<?php
  // if there is something stored in the message array then:
  if(isset($message)){
    // loop over each message
     foreach($message as $message){
       // print out the messages as follows:
        echo '
        <div class="message">
           <span>'.$message.'</span>
           <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
     }
  }
?>
