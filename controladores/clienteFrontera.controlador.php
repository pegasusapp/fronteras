<?php
class ControladorClientesFrontera
{
/**
 * Show Clients function
 * @return array
 */
	static public function ctrMostrarClientesFrontera($item,$valor){
		$tabla = "clienteFrontera";
		return ModeloClientesFrontera::mdlMostrarClientesFronteras($tabla,$item,$valor);
	}

	static public function ctrEditarUsuariosFrontera()
	{
		if(isset($_POST["editarnitCliente"]))
		{
				$tabla = "clienteFrontera";
				$item = "contactoCliente";
				$item2 = "nitCliente";
				$item3 = "emailCliente";
				$item4 = "activo";
				$datos = array("nitCliente"=>$_POST["editarnitCliente"],"contactoCliente"=>$_POST["editarcontactoCliente"],"emailCliente"=>$_POST["editaremailCliente"],"activo"=>$_POST["editaractivo"]);
				$respuesta = ModeloClientesFrontera::mdlEditarClientes($tabla, $datos,$item,$item2,$item3,$item4);
				if($respuesta == "ok"){
					echo ControladorUtilidades::answerScript("¡El cliente ha sido guardado correctamente!","listadoClientes");
				}
				else{
					echo ControladorUtilidades::answerBad($respuesta);
				}
		}
	}
}

