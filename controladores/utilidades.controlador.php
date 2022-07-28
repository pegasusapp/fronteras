<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once 'PHPMailer-master/src/Exception.php';
require_once 'PHPMailer-master/src/PHPMailer.php';
require_once 'PHPMailer-master/src/SMTP.php';
class ControladorUtilidades
{




	/*============================================
	 Respuesta generica
	 =============================================*/
	 static public function answerScript($texto,$back):string{

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

	 static public function answerBad($error):string{
		return "<script>
						Swal.fire({
									icon: 'error',
									title: 'Oops...algo salió mal',
									html: \"".$error."\",
									footer: '<a href=\"errores\">Por favor reportar este error</a>'
								})
				</script>";
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

	 ///// RETORNA DIA MES AÑO ACTUAL separados por guion

	 static public function anyoMesDia($dia):string{


		$fecha_actual = date("d-m-Y");
		
		$dateFix = explode("-",date("Y-n-j",strtotime($fecha_actual."- ".$dia." days"))); 

		$anyo = $dateFix[0];
		$mes =  $dateFix[1];
		$dia =  $dateFix[2];

		return $anyo."-".$mes."-".$dia;

	 }

	 static public function getNumberday($date):int{
		return date('w', strtotime($date));
	 }
	 static public function getDayToMysql($dia):int{
		if($dia == 7)
		{
		 $dayAvg = $dia-6;
		}
		else{
		 $dayAvg = $dia+1;
		}
		return $dayAvg;
	 }

	 static public function tipoEnergia($sigla):string{
        $tEnergia="";
		
		if($sigla === "C"){
			$tEnergia = "Capacitiva";
		}
		elseif($sigla === "P"){
		   $tEnergia = "Penalizada Inductiva";
		}
		elseif($sigla === "A"){
			$tEnergia = "Activa";
		}
		elseif($sigla === "R"){
			$tEnergia = "Reactiva";
		}
		elseif($sigla === "E"){
			$tEnergia = "Exportada";
		 }  

		 return $tEnergia;

	 }

	

 
}

