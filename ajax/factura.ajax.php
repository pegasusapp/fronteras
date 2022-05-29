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

	public function ajaxSearchFactura(){
		$tabla = "facturas";
		$item = "anyo";
		$valor = $this->anyo;
		$item1 = "mes";
		$valor1 = $this->mes;
		$item2 = "frontera_fronteraCliente";
		$valor2 = $this->frontera;

		$respuesta = ControladorFactura::ctrSearchFactura($tabla,$item, $valor,$item1, $valor1,$item2, $valor2);
		if($respuesta > 0){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
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

if(isset($_POST["anyoSearch"]) && isset($_POST["mesSearch"]) && isset($_POST["fronteraSearch"])){

	$search = new AjaxFacturas();
	$search -> anyo = $_POST["anyoSearch"];
	$search -> mes = $_POST["mesSearch"];
	$search -> frontera = $_POST["fronteraSearch"];
	$search -> ajaxSearchFactura();

}

