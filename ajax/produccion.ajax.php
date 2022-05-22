<?php

require_once "../controladores/produccion.controlador.php";
require_once "../modelos/produccion.modelo.php";

class AjaxProduccion
	{

		/*=============================================
		EDITAR PRODUCCION
		=============================================*/	

		public $idproduccion;
		public function ajaxEditarProduccion()
		{
			$item = "idproduccion";
			$valor = $this->idproduccion;
			$respuesta = ControladorProduccion::ctrMostrarProduccion($item, $valor); 
	
			echo json_encode($respuesta);
		}
	}

/*=============================================
EDITAR PRODUCCION
=============================================*/	
if(isset($_POST["idproduccion"]))
	{
		$total_produccion = new AjaxProduccion();
		$total_produccion -> idproduccion = $_POST["idproduccion"];
		$total_produccion -> ajaxEditarProduccion();
	}
