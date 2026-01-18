<?php 
   if($smtp_auth == 1){
      $usarMailSMTP = true;
   } else {
      $usarMailSMTP = false;   
   }
   //Server settings
   $mail->isSMTP();                                            //Send using SMTP
   $mail->Host       = $smtp_host;                     //Set the SMTP server to send through
   $mail->SMTPAuth   = $usarMailSMTP;                                   //Enable SMTP authentication
   $mail->Username   = $smtp_username;                     //SMTP username
   $mail->Password   = $smtp_pass;                               //SMTP password
   $mail->Port       = $smtp_port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


?>

