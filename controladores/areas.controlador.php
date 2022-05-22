<?php

class ControladorAreas{

	/*=============================================
	CREAR AREA
	=============================================*/ 

	static public function ctrCrearArea(){

		if(isset($_POST["nombreArea"])){

			if($_POST["nombreArea"]){

			   	$tabla = "area";

			   	$datos = array("nombreArea"=>$_POST["nombreArea"],"proyecto_idproyecto"=>$_POST["proyecto_idproyecto"]);
			   	$respuesta = ModeloAreas::mdlCrearArea($tabla, $datos);

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
	MOSTRAR AREAS
	=============================================*/

	static public function ctrMostrarAreas($item, $valor){

		$tabla = "area";
		$tabla2 = "proyecto";

		$respuesta = ModeloAreas::mdlMostrarAreas($tabla,$tabla2, $item, $valor);
      	return $respuesta;



	}

	/*=============================================
	EDITAR AREA
	=============================================*/

	static public function ctrEditarArea(){

		if(isset($_POST["idareaE"])){

			if($_POST["nombreAreaE"]){

			   	$tabla = "area";

			   	$datos = array("nombreArea"=>$_POST["nombreAreaE"],"idarea"=>$_POST["idareaE"],"proyecto_idproyecto"=>$_POST["proyecto_idproyectoE"]);

			   	$respuesta = ModeloAreas::mdlEditarArea($tabla, $datos);

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

