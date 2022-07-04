<?php

class ControladorLogLecturaWS
{

    public $tabla = "logLecturasWS";

	static public function ctrCrearLogLecturaWS($datosLogWS):bool{
		
			if(!empty($datosLogWS)){
				return ModeloLogLecturaWS::mdlIngresarLogLecturaWS($tabla,$datosLogWS);

			}		
			

				
		
	}
	/*=============================================
	MOSTRAR Logs
	=============================================*/

	static public function ctrMostrarLogLecturaWS():array
	{

		$item = NULL;
		$valor = NULL;
		return ModeloLogLectura::mdlMostrarLogLecturas($tabla,$item,$valor);
    

	}

}

