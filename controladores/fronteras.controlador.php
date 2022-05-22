<?php
class ControladorFronteras
{

 
	static public function ctrMostrarFronteras($item, $valor)
	{

		$tabla = "frontera";
		//$tabla2 = "fuenteenergia_has_proyecto";

		$respuesta = ModeloFronteras::mdlMostrarFronteras($tabla,$item, $valor);
		//$respuesta = "ok";

      	return $respuesta;



	} 

	static public function ctrMostrarEnergiasFrontera($valor,$dia_curso,$anyo_curso,$mes_curso)
	{


		$respuesta = ModeloFronteras::mdlMostrarEnergiasFronteraDia($valor,$anyo_curso,$mes_curso,$dia_curso);
		//$respuesta = "ok";

      	return $respuesta;



	} 


	static public function ctrMostrarEnergiasFronteraM($valor,$anyo_curso,$mes_curso,$energia)
	{
	

		$respuesta = ModeloFronteras::mdlMostrarEnergiasFronteraMes($valor,$anyo_curso,$mes_curso,$energia);
		//$respuesta = "ok";

      	return $respuesta;



	} 

	static public function ctrMostrarEnergiasFronteraProm($valor,$anyo_curso)
	{
	

		$respuesta = ModeloFronteras::mdlMostrarEnergiasFronteraPromedio($valor,$anyo_curso);
		//$respuesta = "ok";

      	return $respuesta;



	} 

	static public function ajaxCheckFronteraDetalleMes($fronteraEnvio,$anyo_curso,$mes_curso,$energia)
	{
	

		$respuesta = ModeloFronteras::mdlMostrarEnergiasFronteraDetalleMes($fronteraEnvio,$anyo_curso,$mes_curso,$energia);
	
      	return $respuesta;



	}

	static public function crtMostrarTotalConsumoFronterasAnyoEnergia($valor)
	{
		$respuesta = ModeloFronteras::mdlMostrarTotalConsumoFronterasAnyoEnergia($valor);
		return $respuesta;
	}

	static public function crtMostrarTotalConsumoFronterasAnyoMesEnergia($valor)
	{
		$respuesta = ModeloFronteras::mdlMostrarTotalConsumoFronterasAnyoMesEnergia($valor);
		return $respuesta;
	}
	static public function crtMostrarMatrizEnergiaDatos($item, $valor,$item2,$valor2,$valor21,$item3,$valor3)
	{	
		$tabla = "lecturaFrontera";
		$valor2 = date("Y-m-d",strtotime($valor2));	
		$valor21 = date("Y-m-d",strtotime($valor21));	
		$respuesta = ModeloFronteras::mdlMostrarMatrizEnergiaDatos($tabla,$item, $valor,$item2,$valor2,$valor21,$item3,$valor3);
	
		return $respuesta;
	}

	static public function ctrEditarFrontera()
	{
		if(isset($_POST["seguimientoeditar"]))
		{


				$datos = array("seguimiento" => $_POST["seguimientoeditar"],"fronteraCliente" => $_POST["editaridentificador"],"minimoKv" => $_POST["editarminimoKv"]);
				$tabla = "frontera";
				$item = "seguimiento";
				$item2 = "fronteraCliente";
				$item3 = "minimoKv";
				$respuesta = ModeloFronteras::mdlEditarFrontera($tabla,$item,$item2,$item3, $datos);
				if($respuesta == "ok")
				{

					echo '<script>

					swal("¡La frontera ha sido guardada correctamente!", {
						buttons: 
						{
						 catch: 
						   {
						   text: "Cerrar",
						   value: "ok",
						   }
						},
					  })
					  .then((value) => {
						switch (value)
						{
					        case "ok":
						            window.location = "listadoFronteras";
							break;
					   
						    default:
						            window.location = "listadoFronteras";
						}
					  });


					</script>';


				}
				else
				{
					echo "<script>

					Swal.fire({
						icon: 'error',
						title: 'Oops...algo salió mal',
						html: \"".$respuesta."\",
						footer: '<a href=\"errores\">Por favor reportar este error haciendo click aqui</a>'
					})

					</script>";
				}


		}


	}

	static public function ctrConsultarFronteraReportarXM($valor,$energia)
	{
		$respuesta = ModeloFronteras::mdlConsultarFronteraReportarXM($valor,$energia);
		return $respuesta;
	}
	
	static public function ctrCrearFronteraPenalizada($anyo,$mes,$dia,$frontera,$valor)
	{
		$respuesta = ModeloFronteras::mdlCrearFronteraPenalizada($anyo,$mes,$dia,$frontera,$valor);
		return $respuesta;
	}

}

