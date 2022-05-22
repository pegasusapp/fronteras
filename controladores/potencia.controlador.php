<?php

class ControladorPotencias{

	/*=============================================
	CREAR POTENCIA
	=============================================*/ 

	static public function ctrCrearPotencia(){

		if(isset($_POST["nombrePotencia"])){

			if($_POST["nombrePotencia"]){

				   $tabla = "potencia";
				   $tabla2 = "equipo_has_tipopotencia";

			   	$datos = array("nombrePotencia"=>$_POST["nombrePotencia"],"descripcionPotencia"=>$_POST["descripcionPotencia"],"unidad"=>$_POST["unidad"]);
				$respuesta = ModeloPotencias::mdlCrearPotencia($tabla,$tabla2, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						title: "Los datos han sido guardados correctamente!",
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
						  title: "¡El nombre del area no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
							if (result.value) {

							window.location = "areas";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	MOSTRAR POTENCIAS
	=============================================*/

	static public function ctrMostrarPotencias($item, $valor){

		$tabla = "tipopotencia";
		$tabla2 = "equipo_has_potencia";

		$respuesta = ModeloPotencias::mdlMostrarPotencias($tabla, $item, $valor);
      	return $respuesta;



	}

	/*=============================================
	EDITAR POTENCIAS
	=============================================*/

	static public function ctrEditarPotencia(){

		if(isset($_POST["idtipoPotenciaE"])){

			if($_POST["nombrePotenciaE"]){

			   	$tabla = "tipopotencia";

			   	$datos = array("nombrePotencia"=>$_POST["nombrePotenciaE"],"descripcionPotencia"=>$_POST["descripcionPotenciaE"],"unidad"=>$_POST["unidadE"]);

			   	$respuesta = ModeloPotencias::mdlEditarPotencia($tabla, $datos);

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

