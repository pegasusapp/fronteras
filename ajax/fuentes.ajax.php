<?php

require_once "../controladores/fuentes.controlador.php";
require_once "../modelos/fuentes.modelo.php";

class AjaxFuente
	{

		/*=============================================
		EDITAR AREA
		=============================================*/	

		public $idfuente;
		public function ajaxEditarFuente()
		{
			$item = "idfuenteEnergia";
			$valor = $this->idfuente;
			$respuesta = ControladorFuentes::ctrMostrarFuentes($item, $valor);
	
			echo json_encode($respuesta);
		}
	}

/*=============================================
EDITAR AREA
=============================================*/	
if(isset($_POST["idfuenteEnergia"]))
	{
		$area = new AjaxFuente();
		$area -> idfuente = $_POST["idfuenteEnergia"];
		$area -> ajaxEditarFuente();
	}
