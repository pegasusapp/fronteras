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
		$respuesta = ModeloClientes::mdlMostrarClientes($tabla);
      	return $respuesta;



	}

	/*=============================================
	MOSTRAR Clientes INDIVIDUAL
	=============================================*/

	static public function ctrMostrarClientesInd($item,$valor){

		$tabla = "Clientesconsumo";
		$respuesta = ModeloClientes::mdlMostrarClientesInd($tabla,$item, $valor);
      	return $respuesta;



	}
	/*=============================================
	MOSTRAR Clientes DASH
	=============================================*/

	static public function ctrMostrarClientesResumen($item){

		$tabla = "Clientesconsumo";
		
		$respuesta = ModeloClientes::mdlMostrarClientesResumen($tabla, $item);
      	return $respuesta;


 
	} 
	/*=============================================
	MOSTRAR Clientes DASH CONSUMO
	=============================================*/

	static public function ctrMostrarClientesResumenConsumo($grupo1,$grupo2,$filtro,$item2,$valor2,$item3,$valor3){

		$tabla = "Clientesconsumo";

		
		$respuesta = ModeloClientes::mdlMostrarClientesResumenConsumo($tabla, $grupo1,$grupo2,$filtro,$item2,$valor2,$item3,$valor3);
      	return $respuesta;


 
	}		

	/*=============================================
	EDITAR Clientes
	=============================================*/

	static public function ctrEditarClientes()
	{

	
			
				 	
				$tabla = "Clientesconsumo";
			   

				$datos = array("idClientesConsumo"=>$_POST["idClientesConsumoE"],"consumo"=>$_POST["consumoE"],"costo"=>$_POST["costoE"],"indicador"=>$_POST["indicadorE"]);

				$respuesta = ModeloClientes::mdlEditarClientes($tabla, $datos);
				
			    return $respuesta;

			

		    

		
 
	}


}

