<?php

class ControladorProduccion{

	/*=============================================
	CREAR PRODUCCION
	=============================================*/ 

	static public function ctrCrearProduccion(){

		if(isset($_POST["proyecto_idproyecto_produccion"])){

			if($_POST["toneladas"]){

			   	$tabla = "produccion";

			   	$datos = array("anyo"=>$_POST["anyo_produccion"],"mes"=>$_POST["mes_produccion"],
				   "toneladas"=>$_POST["toneladas"],"proyecto_idproyecto"=>$_POST["proyecto_idproyecto_produccion"]);
				   $respuesta = ModeloProduccion::mdlCrearProduccion($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "Los datos han sido guardados correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
									if (result.value) {

									window.location = "produccion";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡Los datos no puede ir vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
							if (result.value) {

							window.location = "produccion";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	MOSTRAR PRODUCCION
	=============================================*/

	static public function ctrMostrarProduccion($item1, $valor1,$item2,$valor2){

		$tabla = "produccion";
		$tabla2= "proyecto";
		$respuesta = ModeloProduccion::mdlMostrarProduccion($tabla,$tabla2,$item1, $valor1,$item2,$valor2);
      	return $respuesta;



	}
 
	/*=============================================
	MOSTRAR PRODUCCION GRAFICAS
	=============================================*/ 

	static public function ctrMostrarProduccionGraficas($item1,$item2, $valor1,$valor2){

		$tabla = "produccion";
		$tabla2 = "totalesconsumo"; 
		$tabla3 = "proyecto";
		$tabla4 = "fuenteenergia";
		$respuesta = ModeloProduccion::mdlMostrarProduccionGraficas($tabla,$tabla2,$tabla3,$tabla4,$item1,$item2, $valor1,$valor2);
      	return $respuesta;



	}
	/*=============================================
	MOSTRAR PRODUCCION GRAFICAS NETO PRODUCCION
	=============================================*/

	static public function ctrMostrarProduccionNeta($item1, $valor1){

		$tabla = "produccion";
		$tabla2 = "proyecto";
	    $respuesta = ModeloProduccion::mdlMostrarProduccionNeta($tabla,$tabla2,$item1, $valor1);
      	return $respuesta;



	}	
	/*=============================================
	MOSTRAR PRODUCCION GRAFICAS NETO PRODUCCION DASH
	=============================================*/

	static public function ctrMostrarProduccionNetaDash($item){

		$tabla = "produccion";
		
	    $respuesta = ModeloProduccion::mdlMostrarProduccionNetaDash($tabla,$item);
      	return $respuesta;



	}

	/*=============================================
	MOSTRAR PRODUCCION GRAFICAS KHW/TON DASH
	=============================================*/

	static public function ctrMostrarkhwtonDash($item,$valor,$item2,$valor2,$item3,$valor3){

		$tabla = "produccion";
		$tabla2 = "totalesconsumo";
		$tabla3 = "proyecto";
		
	    $respuesta = ModeloProduccion::mdlMostrarProduccionGraficasDash($tabla,$tabla2,$tabla3,$item,$valor,$item2,$valor2,$item3,$valor3);
      	return $respuesta;
 


	} 
	/*=============================================
	MOSTRAR PRODUCCION GRAFICAS KHW/TON DASH INDIVIDUAL
	=============================================*/

	static public function ctrMostrarkhwtonDashIndividual($item,$valor){

		$tabla = "produccion";
		$tabla2 = "totalesconsumo";
		$tabla3 = "proyecto";
		
		
	    $respuesta = ModeloProduccion::mdlMostrarProduccionGraficasDashIndividual($tabla,$tabla2,$tabla3,$item,$valor);
      	return $respuesta;



	}
	/*=============================================
	MOSTRAR INDICADOR PRODUCCION  KHW/TON DASH
	=============================================*/

	static public function ctrMostrarProduccionIndicador($fun,$item,$valor,$item2,$valor2,$item3,$valor3){

		$tabla = "produccion";
		$tabla2 = "totalesconsumo";
		$tabla3 = "proyecto";
		$tabla4 ="fuenteenergia";
		
	    $respuesta = ModeloProduccion::mdlMostrarProduccionIndicador($tabla,$tabla2,$tabla3,$tabla4,$fun,$item,$valor,$item2,$valor2,$item3,$valor3);
      	return $respuesta;



	}
	/*=============================================
	EDITAR PRODUCCION
	=============================================*/

	static public function ctrEditarProduccion(){

		if(isset($_POST["idproduccion"])){

			if($_POST["proyecto_idproyecto"]){
				 	
				   $tabla = "produccion";
				  

			   	$datos = array("idproduccion"=>$_POST["idproduccionE"],"anyo"=>$_POST["anyoE"],"mes"=>$_POST["mesE"],
								  "toneladas"=>$_POST["toneladasE"],"proyecto_idproyecto"=>$_POST["proyecto_idproyectoE"]);

				   $respuesta = ModeloProduccion::mdlEditarProduccion($tabla, $datos);
				   
				

			   	if($respuesta == "ok"){

					echo'<script>

					
					swal({
						title: "Los datos han sido cambiados correctamente!",
						text: "",
						type: "success"
					}).then(function() {
						window.location = "produccion";
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
							window.location = "produccion";
						});

			  	</script>';



			}

		}

	}


}

