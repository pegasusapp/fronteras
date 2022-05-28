<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
class ControladorUtilidades
{




	/*============================================
	 Respuesta generica
	 =============================================*/
	 static public function answerScript($texto,$back){

		return '<script>

					swal("¡'.$texto.'!", {
						buttons: 
						{
						 catch: 
						   {
						   text: "Cerrar",
						   value: "ok",
						   }
						},
					  })
					  .then((value) => {
						switch (value)
						{
					        case "ok":
						            window.location = "'.$back.'";
							break;
					   
						    default:
						            window.location = "'.$back.'";
						}
					  });


					</script>';


	 }	

	 static public function sendMail($subject,$emailDestino,$mensajeBody)
	 {
	// La cuenta está bloqueada.
		$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
		try {
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = Constantes::EMAIL_COMPANY;                 // SMTP username
				$mail->Password = Constantes::PASS_EMAIL_COMPANY;                           // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 587;                                     // TCP port to connect to
				$mail->From = Constantes::EMAIL_COMPANY;
				$mail->FromName = Constantes::FROM_NAME_EMAIL;
				$mail->addAddress($emailDestino, 'Usuario :');     // Add a recipient
				$mail->isHTML(true);                                                      // Set email format to HTML
				$mail->Subject = $subject;
				$mail->Body    = $mensajeBody;
				$mail->send();
				
			} 
		catch (Exception $e)
			{
					echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
			}
	 }
	


}

