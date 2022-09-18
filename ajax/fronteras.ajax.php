<?php

require_once "../controladores/fronteras.controlador.php";
require_once "../modelos/fronteras.modelo.php";

class AjaxFrontera
	{

		/*=============================================
		EDITAR PROYECTO
		=============================================*/	

		public $frontera;
		public $dia;
		public $mes;
		public $energia;
		public $anyo;

		public function ajaxCheckFrontera()
		{
		
			$valor = $this->frontera;
			$dia_curso  = $this->dia;
			$anyo_curso = date("Y");
			$mes_curso = date("n");
			
			if($dia_curso == "hoy")
				{
					$dia_curso = date("j");
				} 
			elseif($dia_curso == "ayer")
				{
					
					$fecha = date("Y-m-d", strtotime('-1 day',  time()));
					$reparto = explode("-", $fecha);
					$anyo_curso = $reparto[0];
					$mes_curso  = $reparto[1];
					$dia_curso  = $reparto[2];
					
				}  
			$respuesta = ControladorFronteras::ctrMostrarEnergiasFrontera($valor,$dia_curso,$anyo_curso,$mes_curso);
	
			echo json_encode($respuesta);
		}

		public function ajaxCheckFronteraMes()
		{
			$valor = $this->frontera;
			$anyo_curso = date("Y");
			if($this->mes == "actual")
				{
					$mes_curso = date("n");
				}
				elseif($this->mes == "atras")
				{
					if(date("n") == 1)
					{
						$mes_curso = 12;
						$anyo_curso = date("Y") - 1;
					}
					else
					{
						$mes_curso = date("n") - 1;
					}
				}
			$energy = $this->energia;
			$respuesta = ControladorFronteras::ctrMostrarEnergiasFronteraM($valor,$anyo_curso,$mes_curso,$energy);
			echo json_encode($respuesta);
		}
		public function ajaxCheckFronteraProm(){
			$valor = $this->frontera;
			$anyo_curso = date("Y");
			$respuesta = ControladorFronteras::ctrMostrarEnergiasFronteraProm($valor,$anyo_curso);
			echo json_encode($respuesta);
		}
		public function ajaxCheckFronteraDetalleMes(){
			$fronteraEnvio = $this->frontera;
			$anyo_curso = $this->anyo;
			$mes_curso = $this->mes;
			$energia1 = $this->energia;
			$respuesta = ControladorFronteras::ajaxCheckFronteraDetalleMes($fronteraEnvio,$anyo_curso,$mes_curso,$energia1);
			echo json_encode($respuesta);
		}
		public function ajaxFronteraConsulta(){
			$item="fronteraCliente";
			$fronteraEnvio = $this->frontera;
			$respuesta = ControladorFronteras::ctrMostrarFronteras($item,$fronteraEnvio);
			echo json_encode($respuesta);
		}
	}
/*=============================================
EDITAR PROYECTO
=============================================*/	
if(isset($_POST["frontera"]))
	{
		$front = new AjaxFrontera();
		$front -> frontera = $_POST["frontera"];
		$front -> dia = $_POST["dia"];
		$front -> ajaxCheckFrontera();
	}
if(isset($_POST["frontera_dia"]))
	{
		$front = new AjaxFrontera();
		$front -> frontera = $_POST["frontera_dia"];
		$front -> dia = $_POST["dia"];
		$front -> ajaxCheckFrontera();
	}
if(isset($_POST["frontera_mes"]))
{
	$front = new AjaxFrontera();
	$front -> frontera = $_POST["frontera_mes"];
	$front -> mes = $_POST["mes"];
	$front -> energia = $_POST["energia"];
	$front -> ajaxCheckFronteraMes();
}
if(isset($_POST["frontera_prom"]))
{
	$front = new AjaxFrontera();
	$front -> frontera = $_POST["frontera_prom"];
	$front -> energia = $_POST["energia"];
	$front -> ajaxCheckFronteraProm();
}
if(isset($_POST["energiaDetalle"]))
{
	$front = new AjaxFrontera();
	$front -> frontera = $_POST["fronteraDetalle"];
	$front -> energia = $_POST["energiaDetalle"];
	$front -> mes = $_POST["mesConsultaDetalle"];
	$front -> anyo = $_POST["anyoDetalle"];
	$front -> ajaxCheckFronteraDetalleMes();
}
if(isset($_POST["fronteraConsulta"]))
	{
		$front = new ajaxFrontera();
		$front -> frontera = $_POST["fronteraConsulta"];
		$front -> ajaxFronteraConsulta();
	}