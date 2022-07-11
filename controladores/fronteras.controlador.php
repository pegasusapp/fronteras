<?php

class ControladorFronteras
{
 
 
	static public function ctrMostrarFronteras($item, $valor)
	{

		$tabla = "frontera";
		return ModeloFronteras::mdlMostrarFronteras($tabla,$item, $valor);
      
	} 

	static public function ctrMostrarEnergiasFrontera($valor,$dia_curso,$anyo_curso,$mes_curso)
	{

		return ModeloFronteras::mdlMostrarEnergiasFronteraDia($valor,$anyo_curso,$mes_curso,$dia_curso);
	
	} 


	static public function ctrMostrarEnergiasFronteraM($valor,$anyo_curso,$mes_curso,$energia)
	{
		return ModeloFronteras::mdlMostrarEnergiasFronteraMes($valor,$anyo_curso,$mes_curso,$energia);
	} 

	static public function ctrMostrarEnergiasFronteraProm($valor,$anyo_curso)
	{
		return ModeloFronteras::mdlMostrarEnergiasFronteraPromedio($valor,$anyo_curso);
	} 

	static public function ajaxCheckFronteraDetalleMes($fronteraEnvio,$anyo_curso,$mes_curso,$energia)
	{
		return ModeloFronteras::mdlMostrarEnergiasFronteraDetalleMes($fronteraEnvio,$anyo_curso,$mes_curso,$energia);
	}

	static public function crtMostrarTotalConsumoFronterasAnyoEnergia($valor)
	{
		return ModeloFronteras::mdlMostrarTotalConsumoFronterasAnyoEnergia($valor);
	}

	static public function crtMostrarTotalConsumoFronterasAnyoMesEnergia($valor)
	{
		return ModeloFronteras::mdlMostrarTotalConsumoFronterasAnyoMesEnergia($valor);
	}

	static public function crtMostrarMatrizEnergiaDatos($item, $valor,$item2,$valor2,$valor21,$item3,$valor3)
	{	
		$tabla = "lecturaFrontera";
		$valor2 = date("Y-m-d",strtotime($valor2));	
		$valor21 = date("Y-m-d",strtotime($valor21));	
		return ModeloFronteras::mdlMostrarMatrizEnergiaDatos($tabla,$item, $valor,$item2,$valor2,$valor21,$item3,$valor3);
	
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

					echo ControladorUtilidades::answerScript("La frontera ha sido guardada correctamente","listadoFronteras");

				}
				else
				{
					echo  ControladorUtilidades::answerBad($respuesta);
				}


		}


	}

	static public function ctrConsultarFronteraReportarXM($valor,$energia)
	{
		return ModeloFronteras::mdlConsultarFronteraReportarXM($valor,$energia);
		
	}
	
	static public function ctrCrearFronteraPenalizada($anyo,$mes,$dia,$frontera,$valor)
	{
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
					$myDateTime = DateTime::createFromFormat('d/m/Y', $data[3]);
					$formattedweddingdate = $myDateTime->format('Y-m-d');

					$datosMedidor = array("diaLectura"=>$fecha[0], 
										"mesLectura"=>$fecha[1], 
										"anyoLectura"=>$fecha[2], 
										"medidorFrontera"=>$data[2], 
										"frontera_fronteraCliente"=>$data[0],
										"tipoMedidor"=>"P",
										"fechaCompleta"=>$formattedweddingdate);	
					$horaEA = 1;		
					$datosLecturasEnergiaActiva = array();
					for($i=5;$i<=28;$i++){
						$datosLecturasEnergiaActiva += ["H".$horaEA => $data[$i]];
						$horaEA++;
					}
					$datosLecturasEnergiaActiva +=["tipoEnergia"=>"A"];

					
					$horaEE = 1;
					$datosLecturasEnergiaExportada = array();
					for($i=29;$i<=52;$i++){
						$datosLecturasEnergiaExportada += ["H".$horaEE => $data[$i]];
						$horaEE++;
					}
					$datosLecturasEnergiaExportada +=["tipoEnergia"=>"E"];

					$horaER = 1;
					$datosLecturasEnergiaReactiva = array();
					for($i=53;$i<=76;$i++){
						$datosLecturasEnergiaReactiva += ["H".$horaER => $data[$i]];
						$horaER++;
					}
					$datosLecturasEnergiaReactiva +=["tipoEnergia"=>"R"];

					$horaEC = 1;
					$datosLecturasEnergiaCapacitiva = array();
					for($i=77;$i<=100;$i++){
						$datosLecturasEnergiaCapacitiva += ["H".$horaEC => $data[$i]];
						$horaEC++;
					}
					$datosLecturasEnergiaCapacitiva +=["tipoEnergia"=>"C"];

					$datosLecturasEnergiaPenalizada = array();
					$datosLecturasEnergiaPenalizada = self::ctrChargePenaltyEnergy($datosLecturasEnergiaActiva,$datosLecturasEnergiaReactiva);

					
					if(ModeloFronteras::mdlInsertLecturasFrontera($datosMedidor,$datosLecturasEnergiaActiva,$datosLecturasEnergiaExportada,$datosLecturasEnergiaReactiva,$datosLecturasEnergiaCapacitiva))
					{
						$flagInsert += [$data[3] => true];
					}
					else
					{
						$flagInsert += [$data[3] => false];
					}
				}
			}
		}
		 return empty(array_search(false, $flagInsert));
		  
		  
				
		 
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

       public function ctrChargePenaltyEnergy($arrayActiva,$arrayReactiva):array{
        $datosArrayPenalizadaBack = array();
        $datosArrayPenalizadaBack +=["tipoEnergia"=>"P"];
        $i = 1;
            foreach ($arrayActiva as $key => $valueActiva){
                 if($key<>"tipoEnergia"){
                    $vlrTx = self::ctrCalculePenalty($valueActiva,$arrayReactiva[$key]);
                    $datosArrayPenalizadaBack += ["H".$i => $vlrTx];
                    $i++;
                 }
               
            }
        return $datosArrayPenalizadaBack;
       }

	

}

