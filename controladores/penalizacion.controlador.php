<?php

class ControladorPenalizacion
{


    static public function crtMostrarEnergiaPenalizada($item, $valor){
        $tabla = "penalizacionFrontera";
		return ModeloPenalizacion::mdlMostrarPenalizacion($tabla,$item, $valor);
    }



}