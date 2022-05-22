<?php


 

class ControladorProyectos{

	/*=============================================
	CREAR ITEM
	=============================================*/ 

	static public function ctrCrearProyectos(){

		if(isset($_POST["ubicacionProyecto"])){

			if($_POST["ubicacionProyecto"]){

			   	$tabla = "proyecto";

			   	$datos = array("nombrePlanta"=>$_POST["nombrePlanta"],"ubicacionProyecto"=>$_POST["ubicacionProyecto"],
				   "fechaRegistro"=>$_POST["fechaRegistro"],"tipoInstalacion"=>$_POST["tipoInstalacion"],"nombreMunicipio"=>$_POST["nombreMunicipio"],
					"nombreDepartamento"=>$_POST["nombreDepartamento"],"actividadComercial"=>$_POST["actividadComercial"],"gerentePlanta"=>$_POST["gerentePlanta"],
					 "nroContacto"=>$_POST["nroContacto"],"correoContacto"=>$_POST["correoContacto"],"jefeMantenimiento"=>$_POST["jefeMantenimiento"],"contactoJefe"=>$_POST["contactoJefe"],
					  "correoContactojefe"=>$_POST["correoContactojefe"]);
			   	$respuesta = ModeloProyectos::mdlCrearProyecto($tabla, $datos);
					
			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "La planta ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
									if (result.value) {

									window.location = "proyectos";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡La ubicacion de la planta no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
							if (result.value) {

							window.location = "proyectos";

							}
						})

			  	</script>';



			}

		}

	} 
	/*=============================================
	CREAR CONSUMO
	=============================================*/ 
  
	static public function ctrCrearConsumo(){

		if(isset($_POST["consumo"])){

			if($_POST["costo"]){

			   	$tabla = "totalesConsumo";

			   	$datos = array("anyo"=>$_POST["anyo"],"mes"=>$_POST["mes"],
				   "consumo"=>$_POST["consumo"],"costo"=>$_POST["costo"],"indicador"=>$_POST["indicador"],"fuenteEnergia_idfuenteEnergia"=>$_POST["fuenteEnergia_idfuenteEnergia_consumo"],
					"proyecto_idproyecto"=>$_POST["proyecto_idproyecto_consumo"]);
			   	$respuesta = ModeloProyectos::mdlCrearConsumo($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El consumo ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
									if (result.value) {

									window.location = "proyectos";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El consumo no puede ir vacio!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
							if (result.value) {

							window.location = "proyectos";

							}
						})

			  	</script>';



			}

		}

	} 

	/*=============================================
	MOSTRAR PLANTAS
	=============================================*/
 
	static public function ctrMostrarProyectos($item, $valor){

		$tabla = "proyecto";
		$tabla2 = "fuenteenergia_has_proyecto";

		$respuesta = ModeloProyectos::mdlMostrarProyectos($tabla,$tabla2, $item, $valor);
		//$respuesta = "ok";

      	return $respuesta;



	} 
	/*=============================================
	MOSTRAR PLANTAS V2
	=============================================*/

	static public function ctrMostrarProyectoSimple($item, $valor,$item2,$valor2){

		$tabla = "proyecto";
		

		$respuesta = ModeloProyectos::mdlMostrarProyectoSimple($tabla, $item, $valor,$item2,$valor2);
      	return $respuesta;



	}
	/*=============================================
	MOSTRAR GRUPOS DE PLANTAS 
	=============================================*/

	static public function ctrMostrarGruposProyecto($item, $valor){

		$tabla = "proyecto";
		$tabla2 = "grupoproyecto";
		$relacion1 = "grupoProyecto_idgrupoProyecto";
		$relacion2 = "idgrupoProyecto";
		

		$respuesta = ModeloProyectos::mdlMostrarGruposProyecto($tabla,$tabla2, $item, $valor,$relacion1,$relacion2);
		
      	return $respuesta;



	}

	/*=============================================
	CONTAR PLANTAS
	=============================================*/

	static public function ctrContarProyectos($item, $valor){

		$tabla = "proyecto";
		$respuesta = ModeloProyectos::mdlContarProyectos($tabla,$item, $valor);
      	return $respuesta;



	}
	/*=============================================
	MOSTRAR ITEMS
	=============================================*/

	static public function ctrMostrarProyectosExtra($item, $valor){

		$tabla = "fuenteenergia_has_proyecto";
		$tabla2 = "fuenteenergia";
		$tabla3 = "proyecto";

		$respuesta = ModeloProyectos::mdlMostrarProyectosExtra($tabla,$tabla2,$tabla3, $item, $valor);
		
		return $respuesta;
		//return


	}
	/*=============================================
	EDITAR ITEM
	=============================================*/
 
	static public function ctrEditarProyectos(){

		if(isset($_POST["idproyectoE"])){

			if($_POST["ubicacionProyectoE"]){
				   $tio="";		
				   $tabla = "proyecto";
				   foreach($_POST['fenergia'] as $checkbox)
				   {
					 $tio.=$checkbox . ' ';
				    } 

			   	$datos = array("nombrePlanta"=>$_POST["nombrePlantaE"],"idproyecto"=>$_POST["idproyectoE"],"ubicacionProyecto"=>$_POST["ubicacionProyectoE"],
								  "fechaRegistro"=>$_POST["fechaRegistroE"],"tipoInstalacion"=>$_POST["tipoInstalacionE"],"nombreMunicipio"=>$_POST["nombreMunicipioE"],
								   "nombreDepartamento"=>$_POST["nombreDepartamentoE"],"actividadComercial"=>$_POST["actividadComercialE"],"gerentePlanta"=>$_POST["gerentePlantaE"],
									"nroContacto"=>$_POST["nroContactoE"],"correoContacto"=>$_POST["correoContactoE"],"jefeMantenimiento"=>$_POST["jefeMantenimientoE"],"contactoJefe"=>$_POST["contactoJefeE"],
									 "correoContactojefe"=>$_POST["correoContactojefeE"],"municipio_idmunicipio"=>$_POST['nombreMunicipioE']);
			    $datosf = array("fuentes"=>$_POST['fenergia']);	
				$respuesta = ModeloProyectos::mdlEditarProyecto($tabla, $datos,$datosf);
				   

			   	if($respuesta == "ok"){

					echo'<script>

					
					swal({
						title: "Los datos han sido cambiados correctamente!",
						text: "ok",
						type: "success"
					}).then(function() {
						window.location = "proyectos";
					});
					
					
					</script>';

				}
				else {
					echo'<script>

					
					swal({
						title: "Error los dataos no han sido cambiados correctamente!'.$respuesta.'",
						text: "",
						type: "error"
					}).then(function() {
						window.location = "proyectos";
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
							window.location = "proyectos";
						});

			  	</script>';



			}

		}

	}


}

