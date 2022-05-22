<?php 

require_once "../controladores/totales.controlador.php";
require_once "../modelos/totales.modelo.php";

class AjaxTotales
	{

		/*=============================================
		EDITAR TOTALES
		=============================================*/	

		public $idtotales;
		public function ajaxEditarTotales()
		{ 
			$item = "idtotalesConsumo";
			$valor = $this->idtotales;
			$respuesta = ControladorTotales::ctrMostrarTotalesInd($item, $valor); 
	
			echo json_encode($respuesta);
		}
		public function ajaxSaveTotales()
		{
			$item = "idtotalesConsumo"; 
			$valor = $this->idtotales;
			$respuesta = ControladorTotales::ctrEditarTotales($item, $valor); 
	
			echo json_encode($respuesta);
		}
	}

/*=============================================
EDITAR TOTALES
=============================================*/	
if(isset($_POST["idtotalesConsumo"]))
	{
		$total = new AjaxTotales();
		$total -> idtotales = $_POST["idtotalesConsumo"];
		$total -> ajaxEditarTotales();
	}
if(isset($_POST["idtotalesConsumoE"]))
	{
		$total = new AjaxTotales();
		$total -> idtotales = $_POST["idtotalesConsumoE"];
		$total -> ajaxSaveTotales();
	}