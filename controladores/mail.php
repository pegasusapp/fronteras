<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';


class Mail{


    public function sendMail(){

        	// La cuenta está bloqueada.
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = "notificaciones.italener@gmail.com";                 // SMTP username
            $mail->Password = "zqcjnrsntxejfuuk";                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                     // TCP port to connect to
            $mail->From = "notificaciones.italener@gmail.com";
            $mail->FromName = "Italener";
            $mail->addAddress("oscar.2001601@gmail.com", 'Usuario :');     // Add a recipient
            $mail->isHTML(true);                                                      // Set email format to HTML
            $mail->Subject = "Hola";
            $mail->Body    = "Hola";
            $mail->send();
            
        } 
    catch (Exception $e)
        {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }

}

$mail = new Mail();
$mail -> sendMail();

