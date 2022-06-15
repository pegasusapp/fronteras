<?php

require_once "../controladores/logLectura.controlador.php";
require_once "../modelos/logLectura.modelo.php";

class AjaxlogLectura{

	/*=============================================
	EDITAR LECTURA
	=============================================*/	

	public $idlog;
	public $file;

    public function ajaxBorrarLog(){

		$tabla = "logLecturas";
		$item = "idLogLecturas";
		$valor = $this->idlog;
		$file_pointer = $this->file;

		if(ControladorLogLectura::ctrBorrarLogLectura($tabla,$item, $valor)){
			
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


/*=============================================
BORRAR LOG
=============================================*/
if(isset($_POST["id"])){

	$borrar = new AjaxlogLectura();
	$borrar -> idlog = $_POST["id"];
	$borrar -> file = $_POST["nameFile"];
	$borrar -> ajaxBorrarLog();

}


