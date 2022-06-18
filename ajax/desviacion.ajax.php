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

		$tabla = "desviacion";
		$data = array("iddesviacion" => $this->id, "vlrMinimo" => $this->vlrMinimo, "vlrMaximo" => $this->vlrMaximo);
		
		if(ControladorDesviacion::ctrEditDesviacion($tabla,$data)){
			
  			// Use unlink() function to delete a file
			if (!unlink($_SERVER['DOCUMENT_ROOT']."/docs/lecturas/".$file_pointer)) {
				echo json_encode(false);
			}
			else {
				echo json_encode(true);
			}
		}

	}
}


if(isset($_POST["id"])){

	$edit = new ajaxDesviacion();
	$edit -> id = $_POST["id"];
	$edit -> vlrMinimo = $_POST["vlrMinimo"];
	$edit -> vlrMaximo = $_POST["vlrMaximo"];
	$edit -> ajaxEditDesviacion();

}


