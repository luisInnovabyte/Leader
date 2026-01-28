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
   $mail->Port       = $smtp_port;                                    //TCP port to connect to
   
   // Configuración de cifrado según el puerto
   // Puerto 587 = TLS (STARTTLS)
   // Puerto 465 = SSL (SMTPS)
   // Puerto 25 = Sin cifrado (no recomendado)
   if ($smtp_port == 587) {
      $mail->SMTPSecure = 'tls';      // TLS para puerto 587
   } elseif ($smtp_port == 465) {
      $mail->SMTPSecure = 'ssl';         // SSL para puerto 465
   }
   // Si es puerto 25 u otro, no se establece SMTPSecure (sin cifrado)
   
   // Debug SMTP desactivado (cambiar a 2 para debug)
   $mail->SMTPDebug = 0; // 0 = off, 1 = client, 2 = client and server
   $mail->Debugoutput = 'html'; // Formato de salida


?>

