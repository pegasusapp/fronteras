<?php

require_once "../controladores/proyectos.controlador.php";
require_once "../modelos/proyectos.modelo.php";

class AjaxProyecto
	{

		/*=============================================
		EDITAR PROYECTO
		=============================================*/	

		public $idproyecto;
		public $idproyecto_extra;
		public function ajaxEditarProyecto()
		{
			$item = "idproyecto";
			$valor = $this->idproyecto;
			$respuesta = ControladorProyectos::ctrMostrarProyectos($item, $valor);
	
			echo json_encode($respuesta);
		}

		public function ajaxListProyecto()
		{
			$tabla="proyecto";
			$respuesta = ModeloProyectos::mdlMostrarProyectosAjax($tabla); 
			echo json_encode($respuesta);
		}

	}

class AjaxProyectoExtra
	{

		/*=============================================
		EDITAR PROYECTO
		=============================================*/	
 
		public $idproyecto_extra;
		public function ajaxEditarProyectoExtra()
		{
			$item_extra = "proyecto_idproyecto";
			$valor_extra = $this->idproyecto_extra;
			$respuesta_extra = ControladorProyectos::ctrMostrarProyectosExtra($item_extra, $valor_extra);
	       	echo json_encode($respuesta_extra);
		}
	}
/*=============================================
EDITAR PROYECTO
=============================================*/	
if(isset($_POST["idproyecto"]))
	{
		$trafo = new AjaxProyecto();
		$trafo -> idproyecto = $_POST["idproyecto"];
		$trafo -> ajaxEditarProyecto();
	}
if(isset($_POST["idproyecto_extra"]))
	{
		$trafoExtra = new AjaxProyectoExtra();
		$trafoExtra -> idproyecto_extra = $_POST["idproyecto_extra"];
		$trafoExtra -> ajaxEditarProyectoExtra();
	}
if(isset($_POST["listado_plantas"]))
	{
		$trafoExtra = new AjaxProyecto();
		$trafoExtra -> idproyecto_planta = $_POST["listado_plantas"];
		$trafoExtra -> ajaxListProyecto();
	}