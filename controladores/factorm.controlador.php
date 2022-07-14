<?php

class ControladorFactorM
{

    private static $tabla = "factorm";

	static public function ctrCrearFactorM($datosLog):bool{
		
			if(!empty($datosLog)){
				return ModeloFactorM::mdlIngresarFactorM(self::$tabla,$datosLog);
			}		
			

				
		
	} 
     static public function ctrReportDailyFactorM($tipoEnergia,$frontera):array{

        return ModeloFactorM::mdlReportDailyFactorM(self::$tabla,$tipoEnergia,$frontera);
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

