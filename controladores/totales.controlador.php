<?php

class ControladorTotales{

	/*=============================================
	CREAR TOTALES
	=============================================*/ 

	static public function ctrCrearTotales(){

		if(isset($_POST["proyecto_idproyecto"])){

			if($_POST["fuenteEnergia_idfuenteEnergia"]){

			   	$tabla = "totalesconsumo";

			   	$datos = array("anyo"=>$_POST["anyo"],"mes"=>$_POST["mes"],
				   "consumo"=>$_POST["consumo"],"costo"=>$_POST["costo"],"fuenteEnergia_idfuenteEnergia"=>$_POST["fuenteEnergia_idfuenteEnergia"],
					"proyecto_idproyecto"=>$_POST["proyecto_idproyecto"]);
			   	$respuesta = ModeloProyectos::mdlCrearTotales($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "Los totales han sido guardados correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
						  }).then((result) => {
									if (result.value) {

									window.location = "totales";

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

							window.location = "totales";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	MOSTRAR TOTALES
	=============================================*/

	static public function ctrMostrarTotales($item1, $valor1,$item2,$valor2,$orden){

		$tabla = "totalesconsumo";
		$tabla2 = "fuenteenergia_has_proyecto";
		$tabla3= "proyecto";
		$tabla4= "fuenteenergia";
		$respuesta = ModeloTotales::mdlMostrarTotales($tabla,$tabla2,$tabla3,$tabla4, $item1, $valor1,$item2,$valor2,$orden);
      	return $respuesta;



	}

	/*=============================================
	MOSTRAR TOTALES INDIVIDUAL
	=============================================*/

	static public function ctrMostrarTotalesInd($item,$valor){

		$tabla = "totalesconsumo";
		$respuesta = ModeloTotales::mdlMostrarTotalesInd($tabla,$item, $valor);
      	return $respuesta;



	}
	/*=============================================
	MOSTRAR TOTALES DASH
	=============================================*/

	static public function ctrMostrarTotalesResumen($item){

		$tabla = "totalesconsumo";
		
		$respuesta = ModeloTotales::mdlMostrarTotalesResumen($tabla, $item);
      	return $respuesta;


 
	} 
	/*=============================================
	MOSTRAR TOTALES DASH CONSUMO
	=============================================*/

	static public function ctrMostrarTotalesResumenConsumo($grupo1,$grupo2,$filtro,$item2,$valor2,$item3,$valor3){

		$tabla = "totalesconsumo";

		
		$respuesta = ModeloTotales::mdlMostrarTotalesResumenConsumo($tabla, $grupo1,$grupo2,$filtro,$item2,$valor2,$item3,$valor3);
      	return $respuesta;


 
	}		

	/*=============================================
	EDITAR TOTALES
	=============================================*/

	static public function ctrEditarTotales()
	{

	
			
				 	
				$tabla = "totalesconsumo";
			   

				$datos = array("idtotalesConsumo"=>$_POST["idtotalesConsumoE"],"consumo"=>$_POST["consumoE"],"costo"=>$_POST["costoE"],"indicador"=>$_POST["indicadorE"]);

				$respuesta = ModeloTotales::mdlEditarTotales($tabla, $datos);
				
			    return $respuesta;

			

		    

		
 
	}


}

