<?php

require_once "../controladores/logLectura.controlador.php";
require_once "../modelos/logLectura.modelo.php";

class AjaxEditLogLectura{


	public $idlog;

    public function ajaxEdit(){

		$tabla = "logLecturas";
		$item = "idlogLecturas";
		$id = $this->idlog;

		if(ControladorLogLectura::ctrEditLogLectura($tabla,$item,$id)){
			
			echo json_encode(true);
		}

	}
}

if(isset($_POST["id"])){

	$borrar = new AjaxEditLogLectura();
	$borrar -> idlog = $_POST["id"];
	$borrar -> ajaxEdit();

}


