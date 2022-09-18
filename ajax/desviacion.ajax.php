<?php

require_once "../controladores/desviacion.controlador.php";
require_once "../modelos/desviacion.modelo.php";

class AjaxDesviacion{

	/*=============================================
	EDITAR DESVIACION
	=============================================*/	

	public $id;
	public $vlrMinimo;
	public $vlrMaximo;

    public function ajaxEditDesviacion(){

		$item = "iddesviacion";
		$valor = $this->id;
		
		echo json_encode(ControladorDesviacion::ctrMostrarDesviacion($item, $valor));
		}

	
}


if(isset($_POST["id"])){

	$edit = new ajaxDesviacion();
	$edit -> id = $_POST["id"];
	$edit -> vlrMinimo = $_POST["vlrMinimo"];
	$edit -> vlrMaximo = $_POST["vlrMaximo"];
	$edit -> ajaxEditDesviacion();

}


