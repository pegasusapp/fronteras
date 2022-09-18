<?php

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
			$file_pointer = $this->filename;
  			// Use unlink() function to delete a file
			if (!unlink($_SERVER['DOCUMENT_ROOT']."/docs/facturas/".$this->frontera."/".$folder."/".$file_pointer)) {
				echo json_encode(false);
			}
			else {
				echo json_encode(true);
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


