<?php

require_once "../controladores/perfiles.controlador.php";
require_once "../modelos/perfiles.modelo.php";

class AjaxPerfil
	{

		/*=============================================
		EDITAR PERFIL
		=============================================*/	

		public $idperfilEnergia;
		public function ajaxEditarPerfil()
		{
			$item = "idperfilEnergia";
			$valor = $this->idperfilEnergia;
			$respuesta = ControladorPerfiles::ctrMostrarPerfiles($item, $valor);
	
			echo json_encode($respuesta);
		}
	}

/*=============================================
EDITAR AREA
=============================================*/	
if(isset($_POST["idperfilEnergia"]))
	{
		$perfil = new AjaxPerfil();
		$perfil -> idperfilEnergia = $_POST["idperfilEnergia"];
		$perfil -> ajaxEditarPerfil();
	}
