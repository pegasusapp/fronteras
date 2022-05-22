<?php

class ControladorClientesFrontera
{


	/*=============================================
	MOSTRAR Clientes
	=============================================*/

	static public function ctrMostrarClientesFrontera()
	{

		$tabla = "clienteFrontera";
		$item = NULL;
		$valor = NULL;
		$respuesta = ModeloClientesFrontera::mdlMostrarClientesFronteras($tabla,$item,$valor);
      	return $respuesta;



	}


	/*=============================================
	EDITAR Clientes
	=============================================*/

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
				
			    //return $respuesta;
				if($respuesta == "ok")
				{

					echo '<script>

					swal("¡El cliente ha sido guardado correctamente!", {
						buttons: 
						{
						 catch: 
						   {
						   text: "Cerrar",
						   value: "ok",
						   }
						},
					  })
					  .then((value) => {
						switch (value)
						{
					        case "ok":
						            window.location = "listadoClientes";
							break;
					   
						    default:
						            window.location = "listadoClientes";
						}
					  });


					</script>';


				}
				else
				{
					echo "<script>

					Swal.fire({
						icon: 'error',
						title: 'Oops...algo salió mal',
						html: \"".$respuesta."\",
						footer: '<a href=\"errores\">Por favor reportar este error haciendo click aqui</a>'
					})

					</script>";
				}

			

		    

			}
 
	}


}

