<?php

class ControladorFuentes{

	/*=============================================
	CREAR FUENTE
	=============================================*/ 

	static public function ctrCrearFuente(){

		if(isset($_POST["nombreFuente"])){

			if($_POST["nombreFuente"]){

			   	$tabla = "fuenteenergia";

			   	$datos = array("nombreFuente"=>$_POST["nombreFuente"],"unidadMedidaFuente"=>$_POST["unidadMedidaFuente"]);
			   	$respuesta = ModeloFuentes::mdlCrearFuente($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						title: "Los datos han sido guardados correctamente!",
						text: "",
						type: "success"
					}).then(function() {
						window.location = "fuentes";
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

							window.location = "fuentes";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	MOSTRAR FUENTE
	=============================================*/

	static public function ctrMostrarFuentes($item, $valor){

		$tabla = "fuenteenergia";
		$tabla2 = "proyecto";

		$respuesta = ModeloFuentes::mdlMostrarFuentes($tabla,$tabla2, $item, $valor);
      	return $respuesta;



	}
    /*=============================================
	CONTAR FUENTES
	=============================================*/

	static public function ctrContarFuentes($item, $valor){

		$tabla = "fuenteenergia";
		$respuesta = ModeloFuentes::mdlContarFuentes($tabla,$item, $valor);
      	return $respuesta;



	}

	/*=============================================
	EDITAR FUENTE
	=============================================*/

	static public function ctrEditarFuente(){

		if(isset($_POST["idfuenteEnergiaE"])){

			if($_POST["nombreFuenteE"]){

			   	$tabla = "fuenteEnergia";

			   	$datos = array("nombreFuente"=>$_POST["nombreFuenteE"],"unidadMedidaFuente"=>$_POST["unidadMedidaFuenteE"],"idfuenteEnergia"=>$_POST["idfuenteEnergiaE"]);

			   	$respuesta = ModeloFuentes::mdlEditarFuente($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					
					swal({
						title: "Los datos han sido cambiados correctamente!",
						text: "",
						type: "success"
					}).then(function() {
						window.location = "fuentes";
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
							window.location = "fuentes";
						});

			  	</script>';



			}

		}

	}


}

