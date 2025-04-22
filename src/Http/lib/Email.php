<?php 
namespace src\Http\lib;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

trait Email{

    /** METODO PARA ENVIOS DE CORREOS ELECTRONICOS */
    public static function sendEmail($usuario,String $Asunto,String $Message){
          //Create an instance; passing `true` enables exceptions
          $mail = new PHPMailer();
        
          try {
              //Server settings
              $mail->SMTPDebug =false;                      //Enable verbose debug output
              $mail->isSMTP();                                            //Send using SMTP
              $mail->Host       = env("HOST_MAILER");                     //Set the SMTP server to send through
              $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
              $mail->Username   = env("USERNAME_MAILER");                     //SMTP username
              $mail->Password   = env("PASSWORD_MAILER");                               //SMTP password
              $mail->SMTPSecure = env("SMTP_SECURE_MAILER");            //Enable implicit TLS encryption
              $mail->Port       = env("PORT_MAILER");                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
          
              //Recipients
              $mail->setFrom(env("EMISOR_MAILER"),env("EMISOR_NAME_MAILER"));
              $mail->addAddress($usuario[0]->email, $usuario[0]->username);     //Add a recipient
          
          
              //Content
              $mail->isHTML(true);                                  //Set email format to HTML
              $mail->Subject = $Asunto;
              $mail->Body    = $Message;
              
          
              return $mail->send();
               
          } catch (Exception $e) {
              echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
          }
    }
}