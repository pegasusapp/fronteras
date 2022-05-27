<?php

class ControladorFactura
{


	/*=============================================
	CREAR Facturas
	=============================================*/

	static public function ctrCrearFactura()
	{

				
		if(isset($_POST["nameFile"]))
		{
				$tabla = "facturas";
				
				/*=============================================
				VALIDAR DOCUMENTO
				=============================================*/
                
				$directorio = "docs/facturas/".$_POST["idFrontera"];
				$target_file = $directorio . basename($_FILES["nameFile"]["name"]);
				mkdir($directorio, 0755);

				if(isset($_FILES["nameFile"]["tmp_name"]) || !ControladorValidaciones::validateFile("nameFile","application/pdf") )
				{
					echo ControladorUtilidades::answerScript("El tipo de archivo que intenta subir no es permitido","uploadFile");	
						
				}
				if ($_FILES["nameFile"]["size"] > Constantes::FILE_SIZE) {

					echo ControladorUtilidades::answerScript("El tipo de archivo que intenta subir es mayor a 5 MEGAS, baje el tamaño del archivo","uploadFile");	

				}
				if (file_exists($directorio."/".$_FILES["nameFile"]["name"])) {
					echo ControladorUtilidades::answerScript("El archivo que esta intentando subir ya existe,cambie el nombre del archivo","uploadFile");	

				  }
				
				if (move_uploaded_file($_FILES["nameFile"]["tmp_name"], $target_file)) {
					
					$datos = array("anyo"=>$_POST["anyoFactura"],
								   "mes"=>$_POST["mesFactura"],
				   				   "nameFile"=>$_FILES["nameFile"]["name"],
								   "frontera_fronteraCliente"=>$_POST["idFrontera"]);
				    $respuesta = ModeloFactura::mdlMostrarFactura($tabla,$datos);
				    if($respuesta == "ok"){
						ControladorUtilidades::answerScript("Los datos han sido guardados correctamente","uploadFile");	 
				   
					} 

				  }  


				
		}
      

	}


    


	/*=============================================
	MOSTRAR Facturas
	=============================================*/

	static public function ctrMostrarFactura()
	{

		$tabla = "facturas";
		$item = NULL;
		$valor = NULL;
		return ModeloFactura::mdlMostrarFactura($tabla,$item,$valor);
    

	}


	/*=============================================
	EDITAR Facturas
	=============================================*/

	static public function ctrEditarFactura()
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

