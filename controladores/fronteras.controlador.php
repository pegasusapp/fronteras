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
					$myDateTime = DateTime::createFromFormat('m/d/Y', $data[3]);
					$formattedweddingdate = $myDateTime->format('Y-m-d');

					$datosMedidor = array("diaLectura"=>$fecha[1], 
										"mesLectura"=>$fecha[0], 
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

	static public function ctrPrepareDataToSendWS(){
	 
	 $fecha = explode("-",ControladorUtilidades::anyoMesDia(1));	
	 $fronteras = ModeloFronteras::mdlMostrarFronteras("frontera",$item, $valor);
	 foreach ($fronteras as $value){
			$array = self::ctrConexionLecturasFronteraWS($fecha[0],$fecha[1],$fecha[2],$value["fronteraCliente"]);
			if(!empty($array)){
				if(!self::ctrSendToSaveDataFronteraWS($array,$fecha[0],$fecha[1],$fecha[2]))
				{
				    echo ControladorUtilidades::answerBad("Error en la insercion en la frontera ".$value["fronteraCliente"],"inicio");
					
				}
			}
		}
	}

	static public function ctrConexionLecturasFronteraWS($anyo,$mes,$dia,$frontera):array{
     
		$requestXML="<methodCall>
		<methodName>execute_kw</methodName>
		<params>
			<param>
				<value>
					<string>medicion</string>
				</value>
			</param>
			<param>
				<value>
					<int>".Constantes::USER_WS."</int>
				</value>
			</param>
			<param>
				<value>
					<string>4571</string>
				</value>
			</param>
			<param>
				<value>
					<string>telmetergy.webservices</string>
				</value>
			</param>
			<param>
				<value>
					<string>webserviceConsumosActual</string>
				</value>
			</param>
			<param>
				<value>
					<array>
						<data>
							<value>
							</value>
						</data>
						<data>
							<value>
								<struct>
									<member>
										<name>ano</name>
										<value>
											<int>$anyo</int>
										</value>
									</member>
									<member>
										<name>mes</name>
										<value>
											<int>$mes</int>
										</value>
									</member>
									<member>
										<name>dia</name>
										<value>
											<int>$dia</int>
										</value>
									</member>
									<member>
										<name>codigosic</name>
										<value>
											<string>$frontera</string>
										</value>
									</member>								
								</struct>
							</value>
						</data>
					</array>
				</value>
			</param>
		</params>
		</methodCall>";

		$server = 'https://medicion.telmetergy.com.co/xmlrpc/2/object';
		$headers = [
			"Content-type: text/xml",
			"Content-length: " . strlen($requestXML), "Connection: close",
		];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $server);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXML);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$data = curl_exec($ch);
		$array =  json_decode(json_encode(simplexml_load_string($data)),true);
		$arrayFinish = array();
		if(sizeof($array["params"]["param"]["value"]["struct"]) === 1)
		{
			$total = $array["params"]["param"]["value"]["struct"]["member"]["value"]["array"]["data"]["value"];
			$i=0;
			$arrayFinish = array();
			foreach($total as $valor)
			{
	
				$traceo = $valor["struct"]["member"];
				$arrayInterno = array();
				foreach($traceo as $value)
				 {
					 $arrayInterno += [$value["name"] =>array_shift($value["value"])];
				 }
				$resultado = array_merge($arrayInterno);
				$arrayFinish += array($i => $resultado);
				$i++;
			}
		}
		
		
		return $arrayFinish;
	}

	static public function ctrSendToSaveDataFronteraWS($datos,$anyo,$mes,$dia):bool{

		$datosLecturasEnergiaActiva = array();
		$datosLecturasEnergiaExportada = array();
		$datosLecturasEnergiaCapacitiva = array();
		$datosLecturasEnergiaReactiva = array();

		foreach($datos as $value){

			    $medidor = $value["medidor"];
				$frontera =  $value["codigosic"];

				if($value["canal"] === Constantes::SIGLA_ACTIVA){
					$datosLecturasEnergiaActiva =  self::ctrChargeArrayEnergyType($value,"A");
   				}
				elseif($value["canal"] === Constantes::SIGLA_REACTIVA){
					$datosLecturasEnergiaReactiva = self::ctrChargeArrayEnergyType($value,"R");
				}
				elseif($value["canal"] === Constantes::SIGLA_CAPACITIVA){
					$datosLecturasEnergiaCapacitiva = self::ctrChargeArrayEnergyType($value,"C");
				}
				elseif($value["canal"] === Constantes::SIGLA_EXPORTADA){
					$datosLecturasEnergiaExportada = self::ctrChargeArrayEnergyType($value,"E");
				}

		  }

		$datosMedidor = array("diaLectura"=>$dia, 
										"mesLectura"=>$mes, 
										"anyoLectura"=>$anyo, 
										"medidorFrontera"=>$medidor, 
										"frontera_fronteraCliente"=>$frontera,
										"tipoMedidor"=>"P",
										"fechaCompleta"=>$anyo.'-'.$mes.'-'.$dia);


	return ModeloFronteras::mdlInsertLecturasFrontera($datosMedidor,$datosLecturasEnergiaActiva,$datosLecturasEnergiaExportada,$datosLecturasEnergiaReactiva,$datosLecturasEnergiaCapacitiva);

	}

	static public function ctrChargeArrayEnergyType($vector,$siglaTenergy):array{
		$datosBack = array();

		$datosBack +=["tipoEnergia"=>$siglaTenergy];

		for($i = 1; $i < 24;$i++)
		 {
			$datosBack += ["H".$i => $vector["hora".$i]];
		 }
       return $datosBack;
	}

}

