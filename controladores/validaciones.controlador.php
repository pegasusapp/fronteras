<?php

class ControladorValidaciones
{

	private static $monthName = [
		"1" => "Enero",
		"2" => "Febrero",
		"3" => "Marzo",
		"4" => "Abril",
		"5" => "Mayo",
		"6" => "Junio",
		"7" => "Julio",
		"8" => "Agosto",
		"9" => "Septiembre",
		"10" => "Octubre",
		"11" => "Noviembre",
		"12" => "Diciembre"
	];

	/*=============================================
	Validar tipo de archivo pdf
	=============================================*/

	static public function validateFile($file,$allowedMimes,$allowedExtensions = []): bool
	{
		if (!file_exists($file) || !is_readable($file)) {
			return false;
		}
		// Validar el MIME real del archivo
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$detectedMime = finfo_file($finfo, $file);
		finfo_close($finfo);

		$mimeValid = in_array($detectedMime, $allowedMimes, true);

		// Validar extensión si se especifica
		$extValid = true;
		if (!empty($allowedExtensions)) {
			$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			$extValid = in_array($ext, $allowedExtensions, true);
		} else {
			// Si no se especifican extensiones, deducir del nombre original
			$origExt = strtolower(pathinfo(basename($file), PATHINFO_EXTENSION));
			// Bloquear extensiones peligrosas
			$extValid = !in_array($origExt, ['php','phtml','php7','phar','shtml','cgi','pl','py','sh']);
		}

		return $mimeValid && $extValid;
	}

	static public function monthSelect($month):string{
		
		return self::$monthName[$month];

	}

		


}
