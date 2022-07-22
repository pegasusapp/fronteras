<?php

class ControladorCtrFactorM
{

    private static $tabla = "ctrFactorm";

	static public function ctrCrearctrFactorM($datosLog):bool{
		
			if(!empty($datosLog)){
				return ModeloCtrFactorM::mdlIngresarctrFactorM(self::$tabla,$datosLog);
			}		
			

				
		
	} 
	static public function ctrMostrarctrFactorMLastThreMonths($frontera):array{
		return ModeloFactorM::mdlMostrarctrFactorMLastThreMonths(self::$tabla,$frontera);
	}

	static public function ctrMostrarctrFactorM():array
	{

		$item = NULL;
		$valor = NULL;
		return ModeloFactorM::mdlMostrarctrFactorM(self::$tabla,$item,$valor);
    

	}

}

