<?php

require_once "../controladores/gproyecto.controlador.php";
require_once "../modelos/gproyecto.modelo.php";

class AjaxgProyecto
	{

		/*=============================================
		EDITAR PROYECTO
		=============================================*/	

		public function ajaxListgProyecto()
		{
			$tabla="tipoproyecto";
			$respuesta = ModelogProyecto::mdlMostrargtProyectosAjax($tabla); 
			echo json_encode($respuesta);
		}

		public function ajaxListgMovimiento()
		{
			$tabla="movimiento";
			$respuesta = ModelogProyecto::mdlMostrargtMovimientosAjax($tabla); 
			echo json_encode($respuesta);
		}

		

	}

class AjaxgProyectoMovimientoExtra
	{

		/*=============================================
		EDITAR PROYECTO
		=============================================*/	
 
		public $idgproyecto_extra;
		public function ajaxListargProyectoExtra()
		{
			$item_extra = "gproyecto_idgproyecto";
			$valor_extra = $this->idgproyecto_extra;
			$respuesta_extra = ControladorgProyecto::ctrMostrargProyectosMovimientos($item_extra, $valor_extra);
	       	echo json_encode($respuesta_extra);
		}
	}
	
class AjaxgProyectoEdicion
	{

		/*=============================================
		EDITAR PROYECTO
		=============================================*/	
 
		public $idgproyecto;
		public $idconcepto;
		public $nombreconcepto;
		public $precioconcepto;
		public function ajaxEditargProyecto()
		{
			$item_gproyecto = "idgproyecto";
			$tabla ="gproyecto";
			$tabla2 ="tipoproyecto";
			$tabla3 ="clienteproyecto";
			$valor_gproyecto = $this->idgproyecto;
			$respuesta_gproyecto = ModelogProyecto::mdlMostrargProyecto($item_gproyecto, $valor_gproyecto,$tabla,$tabla2,$tabla3);
	       	echo json_encode($respuesta_gproyecto);
		}
		public function ajaxBorrarConcepto()
		{
			$valor_gconcepto = $this->idconcepto;
			$tabla = "concepto";
			$item = "idconcepto";
			$usuario = $_SESSION["identificador"];
			$respuesta_gconcepto = ModelogProyecto::mdlBorrarConcepto($tabla,$valor_gconcepto,$item,$usuario);
	       	echo json_encode($respuesta_gconcepto);
		}
	}	
/*=============================================
EDITAR gPROYECTO
=============================================*/	
if(isset($_POST["listado_gproyectos"]))
	{
		$trafog = new AjaxgProyecto();
		$trafog -> ajaxListgProyecto();
	}
if(isset($_POST["listado_gmovimientos"]))
	{
		$trafog = new AjaxgProyecto();
		$trafog -> ajaxListgMovimiento();
	}	
if(isset($_POST["idgproyecto_extra"]))
	{
		$trafoExtra = new AjaxgProyectoMovimientoExtra();
		$trafoExtra -> idgproyecto_extra = $_POST["idgproyecto_extra"];
		$trafoExtra -> ajaxListargProyectoExtra();
	}
if(isset($_POST["idgproyecto"]))
	{
		$gproyecto = new AjaxgProyectoEdicion();
		$gproyecto -> idgproyecto = $_POST["idgproyecto"];
		$gproyecto -> ajaxEditargProyecto();
	}
if(isset($_POST["idconcepto"]))
	{
		$gproyectoid = new AjaxgProyectoEdicion();
		$gproyectoid -> idconcepto = $_POST["idconcepto"];
		$gproyectoid -> ajaxBorrarConcepto();
	}	