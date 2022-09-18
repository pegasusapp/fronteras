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
 
	static public function validateFile($file,$fileType): bool
	{
		return in_array($file,$fileType);
	}

	static public function monthSelect($month):string{
		
		return self::$monthName[$month];

	}

		


}

