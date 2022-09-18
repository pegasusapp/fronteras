<?php 

require_once "../controladores/clienteFrontera.controlador.php";
require_once "../modelos/clienteFrontera.modelo.php";

class AjaxClientes
	{

		/*=============================================
		EDITAR TOTALES
		=============================================*/	

		public $nitcliente;
		
		
		public function ajaxListClient()
		{
			
			$tabla = "clienteFrontera";
			$item = "nitCliente";
			$valor =  $this->nitcliente;
			$respuesta = ModeloClientesFrontera::mdlMostrarClientesFronteras($tabla,$item,$valor); 
			echo json_encode($respuesta);
		}
	}

/*=============================================
EDITAR TOTALES
=============================================*/	
if(isset($_POST["nitCliente"]))
	{
		$total = new AjaxClientes();
		$total -> nitcliente = $_POST["nitCliente"];
		$total -> ajaxListClient();
	}
	