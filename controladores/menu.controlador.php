<?php

class ControladorMenu{

	/*=============================================
	CREACIÓN DE MENU 
	=============================================*/

	static public function ctrCrearServicio()
		{

			if( isset($_POST["nombreServicio"]) || $_POST["nombreServicio"] == "")
			{
					$tabla = "servicio";
					$valor = $_POST["nombreServicio"];
					$valor2 = $_POST["plantillaServicio"];
					ModeloMenu::mdlCrearServicio($tabla, $valor, $valor2);
			}

		}	


	static public function ctrCrearProceso(){

			if( (isset($_POST["nombreProceso"]) || $_POST["nombreProceso"] == "") || ( isset($_POST["Servicio_idservicio"]) || $_POST["Servicio_idservicio"]=="") )
			{
					$tabla = "proceso";
					$valor = $_POST["nombreProceso"];
					$valor2 = $_POST["plantillaProceso"];
					$fkvalue = $_POST["Servicio_idservicio"];
					ModeloMenu::mdlCrearProceso($tabla, $valor,$valor2, $fkvalue);
			}

	}

	static public function ctrCrearSubProceso()
	{

		if( (isset($_POST["nombreSubproceso"]) || $_POST["nombreSubproceso"] == "") || ( isset($_POST["Proceso_IdProceso"]) || $_POST["Proceso_IdProceso"]=="") )
		{
				$tabla = "subproceso";
				$valor = $_POST["nombreSubproceso"];
				$valor2 = $_POST["plantillaSubproceso"];
				$fkvalue = $_POST["Proceso_IdProceso"];
				ModeloMenu::mdlCrearSubproceso($tabla, $valor,$valor2, $fkvalue);
		}

	}

	/*=============================================
	MOSTRAR DE MENU  
	=============================================*/

	static public function ctrMostrarMenu($valor)
	{

				$usuario_sesion=$valor;
			   
				return ModeloMenu::mdlMostrarMenu($usuario_sesion);
		

	}

	/*=============================================
	EXPANDE  MENU 
	=============================================*/

	static public function ctrMostrarMenuExpandido($valor)
	{

			   
		return ModeloMenu::mdlExpandirMenu($valor);
		
	}

		/*=============================================
	EDITAR DE MENU 
	=============================================*/

	static public function ctrEditarMenuServicio($valor1,$valor2)
	{
		        $campos="usuario_identificador";
				$valores_servicio = $valor1; 
				$usuario_sesion = $valor2;
			   
				return ModeloMenu::mdlEditarMenuServicio($campos,$valores_servicio,$usuario_sesion);
					

	}

}