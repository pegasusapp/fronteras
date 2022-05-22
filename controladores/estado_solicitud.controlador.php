<?php




class ControladorEstadoSolicitud{

	/*=============================================
	CREAR ITEM
	=============================================*/ 

	static public function ctrCrearEstadoSolicitud(){

		if(isset($_POST["idestado_solicitud"])){

			if($_POST["idestado_solicitud"]){

			   	$tabla = "estado_solicitud";

			   	$datos = array("nombre"=>$_POST["nombre"]);

			   	$respuesta = ModeloEstadoSolicitud::mdlIngresarEstadoSolicitud($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El estado ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
									if (result.value) {

									window.location = "crear-solicitud";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El nombre del estado de la solicitud no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
							if (result.value) {

							window.location = "crear-solicitud";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	MOSTRAR ITEMS
	=============================================*/

	static public function ctrMostrarEstadoSolicitud($item, $valor){

		$tabla = "estado_solicitud";

		$respuesta = ModeloEstadoSolicitud::mdlMostrarEstadoSolicitud($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	EDITAR ITEM
	=============================================*/

	static public function ctrEditarEstadoSolicitud(){

		if(isset($_POST["idestado_solicitud"])){

			if($_POST["idestado_solicitud"]){

			   	$tabla = "estado_solicitud";

			   	$datos = array("idestado_solicitud"=>$_POST["idestado_solicitud"],
			   				   "nombre"=>$_POST["nombre"]);

			   	$respuesta = ModeloEstadoSolicitud::mdlEditarEstadoSolicitud($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El estado  ha sido cambiado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
									if (result.value) {

									window.location = "crear-solicitud";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
							if (result.value) {

							window.location = "crear-solicitud";

							}
						})

			  	</script>';



			}

		}

	}


}

