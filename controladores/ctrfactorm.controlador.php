<?php

class ControladorCtrFactorM
{

    private static $tabla = "ctrfactorm";

	static public function ctrCrearctrFactorM($datosLog):bool{
		
			if(!empty($datosLog)){
				return ModeloCtrFactorM::mdlIngresarctrFactorM(self::$tabla,$datosLog);
			}		
			

				
		
	} 

	static public function ctrMostrarctrFactorM():array
	{

		$item = NULL;
		$valor = NULL;
		return ModeloFactorM::mdlMostrarctrFactorM(self::$tabla,$item,$valor);
    

	}

}

