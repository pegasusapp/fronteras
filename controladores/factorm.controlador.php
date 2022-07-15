<?php

class ControladorFactorM
{

    private static $tabla = "factorm";

	static public function ctrCrearFactorM($datosLog):bool{
		
			if(!empty($datosLog)){
				return ModeloFactorM::mdlIngresarFactorM(self::$tabla,$datosLog);
			}		
			

				
		
	} 
     static public function ctrReportDailyFactorM($frontera,$dias){

        return ModeloFactorM::mdlReportDailyFactorM(self::$tabla,$dias,$frontera);
	 }

	/*=============================================
	MOSTRAR FactorM
	=============================================*/

	static public function ctrMostrarFactorM():array
	{

		$item = NULL;
		$valor = NULL;
		return ModeloFactorM::mdlMostrarFactorM(self::$tabla,$item,$valor);
    

	}

}

