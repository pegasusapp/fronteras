<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once 'PHPMailer-master/src/Exception.php';
require_once 'PHPMailer-master/src/PHPMailer.php';
require_once 'PHPMailer-master/src/SMTP.php';
class ControladorUtilidades
{
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
						switch (value){
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

static public function sendMail($subject,$emailDestino,$mensajeBody,$dataFile):bool
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
				$mail->addAddress($emailDestino, 'Usuario :');
				if(!empty($dataFile)){
				$mail->AddAttachment($dataFile["ubication"].$dataFile["nameFile"].".".$dataFile["extension"], $dataFile["nameFile"].".".$dataFile["extension"]);
				}
				$mail->isHTML(true);                                                      // Set email format to HTML
				$mail->Subject = $subject;
				$mail->Body    = $mensajeBody;
				return $mail->send();
			}
		catch (Exception $e)
			{
				$arrayError = [];
				$arrayError = array("emailDestino"=>$emailDestino,"errorInfo"=>$mail->ErrorInfo);
				self::log_message_array("admin",$arrayError);
				return false;
			}
}




	/**
	 * Return date day-month-Year - parameter left days
	 *
	 * @param int $dia
	 * @return string
	 */
	static public function anyoMesDia($dia):string{
		$fecha_actual = date("d-m-Y");
		$dateFix = explode("-",date("Y-n-j",strtotime($fecha_actual."- ".$dia." days")));
		$anyo = $dateFix[0];
		$mes =  $dateFix[1];
		$dia =  $dateFix[2];
		return $anyo."-".$mes."-".$dia;
	}

	/**
	 * Return date day-month-Year - parameter left days
	 *
	 * @param int $dia
	 * @return string
	 */
	static public function lastPeriodDate($number,$period):string{
		$fecha_actual = date("d-m-Y");
		$dateFix = explode("-",date("Y-n-j",strtotime($fecha_actual."- ".$number." $period")));
		$anyo = $dateFix[0];
		$mes =  $dateFix[1];
		$dia =  $dateFix[2];
		return $anyo."-".$mes."-".$dia;
	}

	function log_message_array(String $userName,Array $arr_Message){
		$logmessage =  '[' . date('Y-m-d h:i:s') .' '.$userName.'] '. print_r($arr_Message,true) . "\n";
		error_log($logmessage, 3,  'logFileControlador.log');
	}

	static public function getNumberday($date):int{
		return date('w', strtotime($date));
	}

	static public function getDayToMysql($dia):int{
		if($dia == 7){
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
		   $tEnergia = "Inductiva";
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

