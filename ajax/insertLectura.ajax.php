<?php

require_once "../controladores/fronteras.controlador.php";
require_once "../modelos/fronteras.modelo.php";

class AjaxInsertLectura{


	public $idlog;
	public $file;

    public function ajaxInsertFile(){

		$valor = $this->idlog;
		$file_pointer = $this->file;

		if(ControladorFronteras::ctrInsertLecturasFrontera($valor,$_SERVER['DOCUMENT_ROOT']."/docs/lecturas/",$file_pointer)){
			
			echo json_encode(true);
		}

	}
}


/*=============================================
BORRAR LOG
=============================================*/
if(isset($_POST["id"])){

	$borrar = new AjaxInsertLectura();
	$borrar -> idlog = $_POST["id"];
	$borrar -> file = $_POST["nameFile"];
	$borrar -> ajaxInsertFile();

}


