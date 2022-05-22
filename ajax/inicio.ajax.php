<?php
require_once "../controladores/produccion.controlador.php";
require_once "../modelos/produccion.modelo.php";

class AjaxInicio
{

	/*=============================================
	EDITAR MENU
	=============================================*/	

	public $idplanta;

    public function ajaxDashboard()
     {

		$cadena="";
		$valor = $this->idplanta;

        $respuesta = ControladorProduccion::ctrMostrarkhwtonDashIndividual($valor);
        
          echo json_encode($respuesta);
    }
} 


/*=============================================
EDITAR USUARIO
=============================================*/
if(isset($_POST["idplanta"])){

	$pintar = new AjaxInicio();
	$pintar -> idplanta = $_POST["idplanta"];
	$pintar -> ajaxDashboard();

}

