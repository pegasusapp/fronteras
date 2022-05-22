<?php

class ControladorAlterno{

	/*=============================================
	CREAR EMPRESA ALTERNA
	=============================================*/ 

	static public function ctrCrearAlterno(){

		if(isset($_POST["empresa"])){

			if($_POST["empresa"]){

			   	$tabla = "alternaempresa";

                   $datos = array("empresa"=>$_POST["empresa"],"sede"=>$_POST["sede"],"fecha"=>$_POST["fecha"],"ciudad"=>$_POST["ciudad"],"departamento"=>$_POST["departamento"]
                                    ,"nrocontacto"=>$_POST["nrocontacto"],"activo"=>$_POST["activo"],"or"=>$_POST["or"],"vlr_activa"=>$_POST["vlr_activa"],"vlr_factura"=>$_POST["vlr_factura"]
                                    ,"vlr_kvh"=>$_POST["vlr_kvh"],"vlr_activa"=>$_POST["vlr_activa"],"m1"=>$_POST["m1"],"m2"=>$_POST["m2"],"m3"=>$_POST["m3"]
                                    ,"m4"=>$_POST["m4"],"m5"=>$_POST["m5"],"m6"=>$_POST["m6"],"prom_mes"=>$_POST["prom_mes"],"mercado"=>$_POST["mercado"],"niveltension"=>$_POST["niveltension"]);
			   	$respuesta = ModeloAlterno::mdlCrearAlterno($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						title: "Los datos han sido guardados correctamente!",
						text: "",
						type: "success"
					}).then(function() {
						window.location = "alterno";
					});

				  </script>';


				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El nombre de la empresa no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
							if (result.value) {

							window.location = "alterno";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	MOSTRAR ALTERNO EMPRESA
	=============================================*/

	static public function ctrMostrarAlterno($item, $valor){

		$tabla = "alternaempresa";
		

		$respuesta = ModeloAlterno::mdlMostrarAlterno($tabla, $item, $valor);
      	return $respuesta;



	}
    /*=============================================
	CONTAR ALTERNO EMPRESA
	=============================================*/

	static public function ctrContarAlterno($item, $valor){

		$tabla = "alternaempresa";
		$respuesta = ModeloAlterno::mdlContarAlterno($tabla,$item, $valor);
      	return $respuesta;



	}

	/*=============================================
	EDITAR ALTERNO EMPRESA
	=============================================*/

	static public function ctrEditarAlterno(){

		if(isset($_POST["vlr_activae"])){

			if($_POST["vlr_activae"]){

			   	$tabla = "alternaempresa";

			   	$datos = array("vlr_activa"=>$_POST["vlr_activae"],"vlr_factura"=>$_POST["vlr_facturae"]
                                    ,"vlr_kvh"=>$_POST["vlr_kvhe"],"m1"=>$_POST["m1e"],"m2"=>$_POST["m2e"],"m3"=>$_POST["m3e"]
									,"m4"=>$_POST["m4e"],"m5"=>$_POST["m5e"],"m6"=>$_POST["m6e"],"m7"=>$_POST["m7e"],"m8"=>$_POST["m8e"],"m9"=>$_POST["m9e"]
									,"m10"=>$_POST["m10e"],"m11"=>$_POST["m11e"],"m12"=>$_POST["m12e"],"prom_mes"=>$_POST["prom_mese"],"mercado"=>$_POST["mercadoe"],"alternaempresa_id"=>$_POST["alternaempresa_ide"]);

				   $respuesta = ModeloAlterno::mdlEditarAlterno($tabla, $datos);
				   echo "--->".$respuesta;

			   	if($respuesta == "ok"){

					echo'<script>

					
					swal({
						title: "Los datos han sido cambiados correctamente!",
						text: "",
						type: "success"
					}).then(function() {
						window.location = "alterno";
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
							window.location = "alterno";
						});

			  	</script>';



			}

		}

	}


}

