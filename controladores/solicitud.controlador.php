<?php




class ControladorSolicitud{

	/*=============================================
	CREAR ITEM
	=============================================*/ 

	static public function ctrCrearSolicitud(){

		if(isset($_POST["nombreCategoriaPlantilla"])){

			if($_POST["nombreCategoriaPlantilla"]){

			   	$tabla = "categoriaplantilla";

			   	$datos = array("nombreCategoriaPlantilla"=>$_POST["nombreCategoriaPlantilla"]);

			   	$respuesta = ModeloCategoria::mdlIngresarCategoria($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "La categoría ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
									if (result.value) {

									window.location = "crear-categoria";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El nombre de la categoría no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
							if (result.value) {

							window.location = "crear-categoria";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	MOSTRAR SOLCIITUD
	=============================================*/

	static public function ctrMostrarSolicitud($item, $valor){

		$tabla_uno = "solicitudes";
		$tabla_dos = "estado_solicitud";

		$respuesta = ModeloSolicitud::mdlMostrarSolicitud($tabla_uno,$tabla_dos, $item, $valor);

		return $respuesta;



	}
		/*=============================================
	MOSTRAR SOLCIITUD
	=============================================*/

	static public function ctrMostrarSolicitudProyeccion($item, $valor){

		$tabla_uno = "solicitudes";
		$tabla_dos = "estado_solicitud";
		$tabla_tres = "proyeccionenergia";
		$tabla_cuatro = "proyeccionenergia_ci";
		$tabla_cinco = "documento";
		$tabla_seis = "usuario";
		$tabla_siete = "transformador";
		$respuesta = ModeloSolicitud::mdlMostrarSolicitudProyeccion($tabla_uno,$tabla_dos,$tabla_tres,$tabla_cuatro,$tabla_cinco,$tabla_seis,$tabla_siete,$item, $valor);

		return $respuesta;



	}

	/*=============================================
	EDITAR ITEM
	=============================================*/

	static public function ctrEditarSolicitud(){

		if(isset($_POST["idsolicitudes"])){

			if($_POST["idsolicitudes"]){

			   	$tabla = "solicitudes";

			   	$datos = array("idsolicitudes"=>$_POST["idsolicitudes"],
			   				   "estado_solicitud_idestado_solicitud"=>$_POST["estado_solicitud_idestado_solicitud"],"observaciones_empresa"=>$_POST["observaciones_empresa"]);

			   	$respuesta = ModeloSolicitud::mdlEditarSolicitud($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "Los datos han sido cambiados correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
									if (result.value) {

									window.location = "mostrar-solicitud";

									}
								})

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
						  }).then((result) => {
							if (result.value) {

							window.location = "mostrar-solicitud";

							}
						})

			  	</script>';



			}

		}

	}


}

