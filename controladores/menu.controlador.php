<?php

class ControladorMenu{

	/*=============================================
	CREACIÓN DE MENU 
	=============================================*/

	static public function ctrCrearServicio()
		{

			if( isset($_POST["nombreServicio"]) or $_POST["nombreServicio"] == "")
			{
					$tabla = "servicio";
					//$item = "idServicio";
					$valor = $_POST["nombreServicio"];
					$valor2 = $_POST["plantillaServicio"];
					$respuestaServicio = ModeloMenu::mdlCrearServicio($tabla, $valor, $valor2);
			}

		}	


	static public function ctrCrearProceso(){

			if( (isset($_POST["nombreProceso"]) or $_POST["nombreProceso"] == "") or ( isset($_POST["Servicio_idservicio"]) or $_POST["Servicio_idservicio"]=="") )
			{
					$tabla = "proceso";
					//$item = "idServicio";
					$valor = $_POST["nombreProceso"];
					$valor2 = $_POST["plantillaProceso"];
					$fkvalue = $_POST["Servicio_idservicio"];
					$respuestaProceso = ModeloMenu::mdlCrearProceso($tabla, $valor,$valor2, $fkvalue);
			}

	}

	static public function ctrCrearSubProceso()
	{

		if( (isset($_POST["nombreSubproceso"]) or $_POST["nombreSubproceso"] == "") or ( isset($_POST["Proceso_IdProceso"]) or $_POST["Proceso_IdProceso"]=="") )
		{
				$tabla = "subproceso";
				//$item = "idServicio";
				$valor = $_POST["nombreSubproceso"];
				$valor2 = $_POST["plantillaSubproceso"];
				$fkvalue = $_POST["Proceso_IdProceso"];
				$respuestaSubProceso = ModeloMenu::mdlCrearSubproceso($tabla, $valor,$valor2, $fkvalue);
		}

	}

	/*=============================================
	MOSTRAR DE MENU  
	=============================================*/

	static public function ctrMostrarMenu($valor)
	{

				$usuario_sesion=$valor;
			   
				$respuestaMenu = ModeloMenu::mdlMostrarMenu($usuario_sesion);
		
				return $respuestaMenu;	

	}

	/*=============================================
	EXPANDE  MENU 
	=============================================*/

	static public function ctrMostrarMenuExpandido($valor)
	{

			   
				$respuestaMenu = ModeloMenu::mdlExpandirMenu($valor);
		
				return $respuestaMenu;	

	}

		/*=============================================
	EDITAR DE MENU 
	=============================================*/

	static public function ctrEditarMenuServicio($valor1,$valor2)
	{
		        $campos="usuario_identificador";
				$valores_servicio = $valor1; 
				$usuario_sesion = $valor2;
			   
				$respuestaMenu = ModeloMenu::mdlEditarMenuServicio($campos,$valores_servicio,$usuario_sesion);
				return $respuestaMenu;	
					

	}

}