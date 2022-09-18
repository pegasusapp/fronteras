<?php

class ControladorPerfiles{

	/*=============================================
	CREAR AREA
	=============================================*/ 

	static public function ctrCrearPerfil(){

		if(isset($_POST["nombre"])){

			if($_POST["nombre"]){

			   	$tabla = "perfilenergia";

			   	$datos = array("nombre"=>$_POST["nombre"],"fuenteEnergia_idfuenteEnergia"=>$_POST["fuenteEnergia_idfuenteEnergia"]);
			   	$respuesta = ModeloPerfiles::mdlCrearPerfil($tabla, $datos);
             
			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						title: "Los datos han sido guardados correctamente!",
						text: "",
						type: "success"
					}).then(function() {
						window.location = "perfiles";
					});

				  </script>';


				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El nombre del perfil no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
							if (result.value) {

							window.location = "perfiles";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	MOSTRAR AREAS
	=============================================*/

	static public function ctrMostrarPerfiles($item, $valor){

		$tabla = "perfilenergia";
		$tabla2 = "fuenteenergia";

		$respuesta = ModeloPerfiles::mdlMostrarPerfil($tabla,$tabla2, $item, $valor);
      	return $respuesta;



	}
/*=============================================
	MOSTRAR AREAS DASH
	=============================================*/

	static public function ctrMostrarPerfilesDash($item, $valor){

		$tabla = "perfilenergia";
		
		$respuesta = ModeloPerfiles::mdlMostrarPerfilDash($tabla,$item, $valor);
      	return $respuesta;



	}

	/*=============================================
	EDITAR AREA
	=============================================*/

	static public function ctrEditarPerfil(){

		if(isset($_POST["idperfilEnergiaE"])){

			if($_POST["nombreE"]){

			   	$tabla = "perfilenergia";

			   	$datos = array("nombre"=>$_POST["nombreE"],"fuenteEnergia_idfuenteEnergia"=>$_POST["fuenteEnergia_idfuenteEnergiaE"]);

			   	$respuesta = ModeloPerfiles::mdlEditarPerfil($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					
					swal({
						title: "Los datos han sido cambiados correctamente!",
						text: "",
						type: "success"
					}).then(function() {
						window.location = "areas";
					});
					
					
					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡Hacen falta datos  o hay caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						}).then(function() {
							window.location = "area";
						});

			  	</script>';



			}

		}

	}


}

