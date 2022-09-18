<?php

class ControladorClientes
{

	/*=============================================
	CREAR Clientes
	=============================================*/

	static public function ctrCrearClientes(){

		if(isset($_POST["nombreClienteProyecto"]))
		{

			if($_POST["nombreClienteProyecto"])
			{

			   	$tabla = "clienteproyecto";

			   	$datos = array("nombreClienteProyecto"=>$_POST["nombreClienteProyecto"],"emailCliente"=>$_POST["emailCliente"],
				   "telefonoCliente"=>$_POST["telefonoCliente"],"identificacionCliente"=>$_POST["identificacionCliente"]);
				   $respuesta = ModeloClientes::mdlCrearClientes($tabla, $datos);
				 return $respuesta;	
			    

			}

		}

	}

	/*=============================================
	MOSTRAR Clientes
	=============================================*/

	static public function ctrMostrarClientes()
	{

		$tabla = "clienteproyecto";
		return  ModeloClientes::mdlMostrarClientes($tabla);

	}




}

