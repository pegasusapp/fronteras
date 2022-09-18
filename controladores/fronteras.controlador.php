<?php

class ControladorFronteras
{
	private static $tabla = "lecturaFrontera";

	static public function ctrMostrarFronteras($item, $valor){
		$tablaFrt="frontera";
		return ModeloFronteras::mdlMostrarFronteras($tablaFrt,$item, $valor);
	}

	static public function ctrMostrarEnergiasFrontera($valor,$dia_curso,$anyo_curso,$mes_curso){

		return ModeloFronteras::mdlMostrarEnergiasFronteraDia($valor,$anyo_curso,$mes_curso,$dia_curso);
	}


	static public function ctrMostrarEnergiasFronteraDiaxEnergia($valor,$time,$energia){

		return ModeloFronteras::mdlMostrarEnergiaFronteraxDiaxEnergia($valor,$time,$energia);
	}

	static public function ctrmMostrarTotalFronteraxPeriodoComparativo($frontera,$number,$period,$tipoEne,$tipoMed){
		return ModeloFronteras::mdlMostrarTotalFronteraxPeriodoComparativo($frontera,$number,$period,$tipoEne,$tipoMed);
	}


	static public function ctrMostrarEnergiaFronteraMesEnergia($frontera){

		return ModeloFronteras::mdlMostrarEnergiasFronteraMesEnergia(self::$tabla,$frontera);
	}


	static public function ctrMostrarEnergiasFronteraM($valor,$anyo_curso,$mes_curso,$energia){
		return ModeloFronteras::mdlMostrarEnergiasFronteraMes($valor,$anyo_curso,$mes_curso,$energia);
	}

	static public function ctrMostrarAvgEnergiasFrontera($valor,$energia,$time){
		return ModeloFronteras::mdlMostrarAvgEnergiasFrontera($valor,$energia,$time);
	}

	static public function ctrMostrarEnergiasFronteraProm($valor,$anyo_curso){
		return ModeloFronteras::mdlMostrarEnergiasFronteraPromedio($valor,$anyo_curso);
	}

	static public function ajaxCheckFronteraDetalleMes($fronteraEnvio,$anyo_curso,$mes_curso,$energia){
		return ModeloFronteras::mdlMostrarEnergiasFronteraDetalleMes($fronteraEnvio,$anyo_curso,$mes_curso,$energia);
	}

	static public function crtMostrarTotalConsumoFronterasAnyoEnergia($valor){
		return ModeloFronteras::mdlMostrarTotalConsumoFronterasAnyoEnergia($valor);
	}

	static public function crtMostrarTotalConsumoFronterasAnyoMesEnergia($valor){
		return ModeloFronteras::mdlMostrarTotalConsumoFronterasAnyoMesEnergia($valor);
	}

	static public function crtMostrarMatrizEnergiaDatos($item, $valor,$valor2,$valor21,$item3,$valor3){
		$valor2 = date("Y-m-d",strtotime($valor2));
		$valor21 = date("Y-m-d",strtotime($valor21));
		return ModeloFronteras::mdlMostrarMatrizEnergiaDatos(self::$tabla,$item, $valor,$valor2,$valor21,$item3,$valor3);
	}

	static public function ctrEditarFrontera(){
		if(isset($_POST["seguimientoeditar"])){
				$datos = array("seguimiento" => $_POST["seguimientoeditar"],"fronteraCliente" => $_POST["editaridentificador"],"minimoKv" => $_POST["editarminimoKv"]);
				$tabla = "frontera";
				$item = "seguimiento";
				$item2 = "fronteraCliente";
				$item3 = "minimoKv";
				$respuesta = ModeloFronteras::mdlEditarFrontera($tabla,$item,$item2,$item3, $datos);
				if($respuesta == "ok")
				{
					echo ControladorUtilidades::answerScript("La frontera ha sido guardada correctamente","listadoFronteras");
				}
				else
				{
					echo  ControladorUtilidades::answerBad($respuesta);
				}
		}
	}

	static public function ctrConsultarFronteraReportarXM($valor,$energia){
		return ModeloFronteras::mdlConsultarFronteraReportarXM($valor,$energia);
	}

	static public function ctrCrearFronteraPenalizada($anyo,$mes,$dia,$frontera,$valor){
		return ModeloFronteras::mdlCrearFronteraPenalizada($anyo,$mes,$dia,$frontera,$valor);
	}

	static public function ctrInsertLecturasFrontera($ruta,$file):bool{
		$row = 1;
		$flagInsert = array();
		if (($handle = fopen($_SERVER['DOCUMENT_ROOT'].$ruta.$file, "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$row++;
			if($row > 3){
					$fecha = explode("/",$data[3]);
					$myDateTime = DateTime::createFromFormat('m/d/Y', $data[3]);
					$formattedweddingdate = $myDateTime->format('Y-m-d');
					$datosMedidor = array("diaLectura"=>$fecha[1],
										"mesLectura"=>$fecha[0],
										"anyoLectura"=>$fecha[2],
										"medidorFrontera"=>$data[2],
										"frontera_fronteraCliente"=>$data[0],
										"tipoMedidor"=>"P",
										"fechaCompleta"=>$formattedweddingdate);
					$datosLecturasEnergiaActiva = array();
					$datosLecturasEnergiaExportada = array();
					$datosLecturasEnergiaReactiva = array();
					$datosLecturasEnergiaCapacitiva = array();
					$datosLecturasEnergiaActiva = self::ctrChargeEnergyArray(5,28,"A",$data);
					$datosLecturasEnergiaExportada = self::ctrChargeEnergyArray(29,52,"E",$data);
					$datosLecturasEnergiaReactiva = self::ctrChargeEnergyArray(53,76,"R",$data);
					$datosLecturasEnergiaCapacitiva = self::ctrChargeEnergyArray(77,100,"C",$data);
					$datosLecturasEnergiaPenalizada = array();
					$datosLecturasEnergiaPenalizada = self::ctrChargePenaltyEnergy($datosLecturasEnergiaActiva,$datosLecturasEnergiaReactiva,$data[0],$formattedweddingdate);
					if(ModeloFronteras::mdlInsertLecturasFrontera($datosMedidor,$datosLecturasEnergiaActiva,$datosLecturasEnergiaExportada,$datosLecturasEnergiaReactiva,$datosLecturasEnergiaCapacitiva,$datosLecturasEnergiaPenalizada)){
						$flagInsert += [$data[3] => true];
					}
					else{
						$flagInsert += [$data[3] => false];
					}
				}
			}
		}
		return empty(array_search(false, $flagInsert));
	}

	public function ctrChargeEnergyArray($inicial,$final,$typeEnergy,$vector):array{
		$hora = 1;
		$arrayBack = array();
		$arrayFactorM = array();
		$counter = 0;
		$myDateTime = DateTime::createFromFormat('m/d/Y', $vector[3]);
		$fechaConvertida = $myDateTime->format('Y-m-d');
		$arrayBack +=["tipoEnergia"=>$typeEnergy];
			for($i=$inicial;$i<=$final;$i++){
				$arrayBack += ["H".$hora => $vector[$i]];
				if($typeEnergy === "C" && $vector[$i] > 0)
				{
					$counter += $vector[$i];
				}
				$hora++;
			}
			if($typeEnergy === "C"){
				$arrayFactorM = array("tipoEnergia" => "C",
				"cantidad" => $counter,
				"frontera_fronteraCliente" => $vector[0],
				"fecha" =>$fechaConvertida);
				ControladorFactorM::ctrCrearFactorM($arrayFactorM);
			}
		return $arrayBack;
	}

	public function ctrCalculePenalty($vlrActive,$vlrReactive):int{
     
        $operacion_a = $vlrActive*0.5;
        $vlrHoraPenalizada =0;
        if($vlrReactive > $operacion_a)
        {
            $vlrHoraPenalizada = $vlrReactive - $operacion_a;
        }

        return $vlrHoraPenalizada;

       }

       public function ctrChargePenaltyEnergy($arrayActiva,$arrayReactiva,$frontera,$fecha):array{
        $datosArrayPenalizadaBack = array();
        $datosArrayPenalizadaBack +=["tipoEnergia"=>"P"];
		$arrayFactorM = array();
		$counter = 0;	
        $i = 1;
            foreach ($arrayActiva as $key => $valueActiva){
                 if($key<>"tipoEnergia"){
                    $vlrTx = self::ctrCalculePenalty($valueActiva,$arrayReactiva[$key]);
                    $datosArrayPenalizadaBack += ["H".$i => $vlrTx];
					if($vlrTx > 0)
						{
							$counter += $vlrTx;
						}
                    $i++;
                 }
               
            }
				$arrayFactorM = array("tipoEnergia" => "P",
				"cantidad" => $counter,
				"frontera_fronteraCliente" =>$frontera,
			    "fecha" => $fecha);
				ControladorFactorM::ctrCrearFactorM($arrayFactorM);

		
        return $datosArrayPenalizadaBack;
       }

	

}

