<?php

require_once "../controladores/alterno.controlador.php";
require_once "../modelos/alterno.modelo.php";

class AjaxAlterno
	{

		/*=============================================
		EDITAR Alterno
		=============================================*/	

		public $idalterna;
		public function ajaxEditarAlterna()
		{
			$item = "alternaempresa_id";
			$valor = $this->idalterna;
			$respuesta = ControladorAlterno::ctrMostrarAlterno($item, $valor);
	
			echo json_encode($respuesta);
		}
	}

/*=============================================
EDITAR ALTERNO
=============================================*/	
if(isset($_POST["alternaempresa_id"]))
	{
		$alterna = new AjaxAlterno();
		$alterna -> idalterna = $_POST["alternaempresa_id"];
		$alterna -> ajaxEditarAlterna();
	}
