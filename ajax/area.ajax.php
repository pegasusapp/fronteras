<?php

require_once "../controladores/areas.controlador.php";
require_once "../modelos/areas.modelo.php";

class AjaxArea
	{

		/*=============================================
		EDITAR AREA
		=============================================*/	

		public $idarea;
		public function ajaxEditarArea()
		{
			$item = "idarea";
			$valor = $this->idarea;
			$respuesta = ControladorAreas::ctrMostrarAreas($item, $valor);
	
			echo json_encode($respuesta);
		}
	}

/*=============================================
EDITAR AREA
=============================================*/	
if(isset($_POST["idarea"]))
	{
		$area = new AjaxArea();
		$area -> idarea = $_POST["idarea"];
		$area -> ajaxEditarArea();
	}
