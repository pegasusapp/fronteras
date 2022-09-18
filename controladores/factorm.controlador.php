<?php

class ControladorFactorM
{

    private static $tabla = "factorm";

	static public function ctrCrearFactorM($datosLog):bool{
			if(!empty($datosLog)){
				return ModeloFactorM::mdlIngresarFactorM(self::$tabla,$datosLog);
			}
	}
	static public function ctrReportDailyFactorM($tipoEnergia,$frontera,$dias):array{

        return ModeloFactorM::mdlReportDailyFactorM(self::$tabla,$tipoEnergia,$dias,$frontera);
	}

	/*=============================================
	MOSTRAR FactorM
	=============================================*/

	static public function ctrMostrarFactorM($item,$valor):array{
		return ModeloFactorM::mdlMostrarFactorM(self::$tabla,$item,$valor);
	}
}

