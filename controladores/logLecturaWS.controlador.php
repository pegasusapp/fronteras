<?php

class ControladorLogLecturaWS
{

    private static $tabla = "logLecturasWS";

	static public function ctrCrearLogLecturaWS($datosLogWS):bool{
		
			if(!empty($datosLogWS)){
				return ModeloLogLecturaWS::mdlIngresarLogLecturaWS(self::$tabla,$datosLogWS);
			}		
			

				
		
	}
	/*=============================================
	MOSTRAR Logs
	=============================================*/

	static public function ctrMostrarLogLecturaWS():array
	{

		$item = NULL;
		$valor = NULL;
		return ModeloLogLectura::mdlMostrarLogLecturas(self::$tabla,$item,$valor);
    

	}

}

