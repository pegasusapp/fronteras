<?php
require_once __DIR__ . "/_guard.php";
require_once "../controladores/factura.controlador.php";
require_once "../modelos/factura.modelo.php";

class AjaxFacturas{

	/*=============================================
	EDITAR FACTURA
	=============================================*/	

	public $anyo;
	public $mes;
	public $frontera;
	public $filename;

    public function ajaxBorrarFactura(){

		$tabla = "facturas";
		$item = "anyo";
		$valor = $this->anyo;
		$item1 = "mes";
		$valor1 = $this->mes;
		$item2 = "frontera_fronteraCliente";
		$valor2 = $this->frontera;


		$respuesta = ControladorFactura::ctrBorrarFactura($tabla,$item, $valor,$item1, $valor1,$item2, $valor2);
		$folder = $this->anyo.$this->mes;
		if($respuesta){
			$file_pointer = basename($this->filename);
			$safeFrontera = basename($this->frontera);
			$safeFolder = basename($folder);
			// Construir y validar la ruta
			$baseDir = realpath($_SERVER['DOCUMENT_ROOT'] . "/docs/facturas");
			$targetPath = realpath($baseDir . "/" . $safeFrontera . "/" . $safeFolder . "/" . $file_pointer);
			if ($baseDir !== false && $targetPath !== false && strpos($targetPath, $baseDir) === 0) {
				// Validar extensión segura (solo PDF)
				$ext = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
				if (in_array($ext, array('pdf'))) {
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
EDITAR USUARIO
=============================================*/
if(isset($_POST["anyo"]) && isset($_POST["mes"]) && isset($_POST["frontera"])){

	$borrar = new AjaxFacturas();
	$borrar -> anyo = $_POST["anyo"];
	$borrar -> mes = $_POST["mes"];
	$borrar -> frontera = $_POST["frontera"];
	$borrar -> filename = $_POST["filename"];
	$borrar -> ajaxBorrarFactura();

}
