<?php
require_once __DIR__ . "/_guard.php";
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
		$file_pointer = basename($this->file);

		if(ControladorLogLectura::ctrBorrarLogLectura($tabla,$item, $valor)){
			// Validar que la ruta se mantiene dentro de docs/lecturas
			$baseDir = realpath($_SERVER['DOCUMENT_ROOT'] . "/docs/lecturas");
			$targetPath = realpath($baseDir . "/" . $file_pointer);
			if ($baseDir !== false && $targetPath !== false && strpos($targetPath, $baseDir) === 0) {
				$ext = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
				if (in_array($ext, array('csv', 'txt', 'tsv'))) {
					if (!unlink($targetPath)) {
						echo json_encode(false);
					} else {
						echo json_encode(true);
					}
				} else {
					echo json_encode(false);
				}
			} else {
				echo json_encode(false);
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
