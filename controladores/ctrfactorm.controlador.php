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
		return ModeloCtrFactorM::mdlMostrarctrFactorMLastThreMonths(self::$tabla,$frontera);
	}

	static public function ctrMostrarctrFactorM($item,$valor):array
	{
		return ModeloCtrFactorM::mdlMostrarctrFactorM(self::$tabla,$item,$valor);
    

	}

}

