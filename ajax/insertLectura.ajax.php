<?php

require_once "../controladores/fronteras.controlador.php";
require_once "../modelos/fronteras.modelo.php";

class AjaxInsertLectura{


	public $idlog;
	public $file;

    public function ajaxInsertFile(){

	
		$file_pointer = $this->file;

		if(ControladorFronteras::ctrInsertLecturasFrontera("/docs/lecturas/",$file_pointer)){
			
			echo json_encode(true);
		}

	}
}

if(isset($_POST["id"])){

	$borrar = new AjaxInsertLectura();
	$borrar -> idlog = $_POST["id"];
	$borrar -> file = $_POST["nameFile"];
	$borrar -> ajaxInsertFile();

}


