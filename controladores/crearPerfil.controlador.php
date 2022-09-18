<?php


class ControladorPerfil{
 
	/*=============================================
	CREAR ITEM
	=============================================*/ 

	static public function ctrCrearPerfil(){

		if(isset($_POST["nombre"])){

			if($_POST["nombre"]){

			   	$tabla = "perfilusuarios";

			   	$datos = array("nombre"=>$_POST["nombre"],"descripcion"=>$_POST["descripcion"]);

			   	$respuesta = ModeloPerfil::mdlIngresarPerfil($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal("¡El perfil ha sido guardado correctamente!", {
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
						            window.location = "crearUsuario";
							break;
					   
						    default:
						            window.location = "crearUsuario";
						}
					  });


					</script>';

				}

			}else{

				echo'<script>

				swal("¡El perfil no puede ir vacio o con caracteres especiales!", {
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
								window.location = "crearUsuario";
						break;
				   
						default:
								window.location = "crearUsuario";
					}
				  });

			  	</script>';



			}

		}

	}

	/*=============================================
	MOSTRAR ITEMS
	=============================================*/

	static public function ctrMostrarPerfil($item, $valor){

		$tabla = "perfilusuarios";

		$respuesta = ModeloPerfil::mdlMostrarPerfil($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	EDITAR ITEM
	=============================================*/

	static public function ctrEditarPerfil(){

		if(isset($_POST["editarnombre"])){

			if($_POST["editarnombre"]){

			   	$tabla = "perfilusuarios";

			   	$datos = array("idPerfilUsuarios"=>$_POST["idPerfilUsuarios"],
			   				   "nombre"=>$_POST["editarnombre"],"descripcion"=>$_POST["editardescripcion"]);

			   	$respuesta = ModeloPerfil::mdlEditarPerfil($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal("¡El perfil ha sido cambiado correctamente!", {
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
						            window.location = "crearUsuario";
							break;
					   
						    default:
						            window.location = "crearUsuario";
						}
					  });

					</script>';

				}

			}else{

				echo'<script>

					swal("¡El perfil no puede ir vacio o con caracteres especiales!", {
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
								window.location = "crearUsuario";
						break;
				   
						default:
								window.location = "crearUsuario";
					}
				  });

			  	</script>';



			}

		}

	}


}

