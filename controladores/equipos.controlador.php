<?php

class ControladorEquipos{

	/*=============================================
	CREAR AREA
	=============================================*/ 

	static public function ctrCrearEquipo(){

		if(isset($_POST["nombreEquipo"])){

			if($_POST["nombreEquipo"]){

				   $tabla = "equipo";
				   $tabla2 = "equipo_has_tipopotencia";

			   	$datos = array("nombreEquipo"=>$_POST["nombreEquipo"],"area_idarea"=>$_POST["area_idarea"],"observaciones"=>$_POST["observaciones"],"unidades"=>$_POST["unidades"],"horasUsoDia"=>$_POST["horasUsoDia"],"diasUsoMes"=>$_POST["diasUsoMes"],"perfilEnergia_idperfilEnergia"=>$_POST["perfilEnergia_idperfilEnergia"]);
				$datos_potencia = array();
				   if(!empty($_POST['tipoPotencia_idtipoPotencia']))
				     {
						// Loop to store and display values of individual checked checkbox.
							foreach($_POST['tipoPotencia_idtipoPotencia'] as $selected)
								{
									
									$datos_potencia[] = $selected."-".$_POST["cantidad_".$selected];  
								}
					 }
				
				  // $datos_potencia = array();   
				   $respuesta = ModeloEquipos::mdlCrearEquipos($tabla,$tabla2, $datos,$datos_potencia);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						title: "Los datos han sido guardados correctamente!",
						text: "",
						type: "success"
					}).then(function() {
						window.location = "equipos";
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

							window.location = "equipos";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	MOSTRAR EQUIPOS
	=============================================*/

	static public function ctrMostrarEquipos($item, $valor){

		$tabla = "equipo";
		$tabla2 = "equipo_has_tipopotencia";
		$tabla3 = "tipopotencia";
		$tabla4 = "area";
		$tabla5 = "proyecto";
		$tabla6 = "perfilenergia";

		$respuesta = ModeloEquipos::mdlMostrarEquipos($tabla,$tabla2,$tabla3,$tabla4,$tabla5,$tabla6, $item, $valor);
      	return $respuesta;



	}

	/*=============================================
	EDITAR AREA
	=============================================*/

	static public function ctrEditarEquipo(){

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

