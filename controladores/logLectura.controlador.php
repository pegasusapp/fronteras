<?php

class ControladorLogLectura
{



	static public function ctrCrearLogLectura()
	{
		if(isset($_POST["frontera_fronteraCliente"]))
		{
				
			    $tabla = "logLecturas";
				/*=============================================
				VALIDAR SI EXISTE DOCUMENTO
				=============================================*/
				if(self::ctrSearchLogLectura($tabla,"frontera_fronteraCliente", $_POST["idFrontera"]) > 0)
				{
					//update proceso
				}
				else{
                
				$directorio = "docs/lecturas/".$_POST["idFrontera"];
				$target_file = $directorio."/".basename($_FILES["nameFile"]["name"]);
				if (!is_dir($directorio)) {
					mkdir($directorio, 0755,true);
				}

				$filetype = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');

				if(!ControladorValidaciones::validateFile($_FILES["nameFile"]["tmp_name"],$filetype))
				{
					echo ControladorUtilidades::answerScript("El tipo de archivo que intenta subir no es permitido","uploadFile");	
						
				}
				if ($_FILES["nameFile"]["size"] > Constantes::FILE_SIZE) {

					echo ControladorUtilidades::answerScript("El tipo de archivo que intenta subir es mayor a 5 MEGAS, baje el tamaño del archivo","uploadFile");	

				}
				if (file_exists($directorio."/".$_FILES["nameFile"]["name"])){
					echo ControladorUtilidades::answerScript("El archivo que esta intentando subir ya existe,cambie el nombre del archivo","uploadFile");	
				  }
				
				if (move_uploaded_file($_FILES["nameFile"]["tmp_name"], $target_file)){

						$row = 1;
						if (($handle = fopen($_FILES["nameFile"]["name"], "r")) !== FALSE) {
						while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
							
							$row++;
							if($row > 3){
								$datosLog = array("frontera_fronteraCliente"=>$_POST["idFrontera"],
												  "nameFile"=>$_FILES["nameFile"]["name"],
												  "upload"=>0);

								$fecha = explode("/",$data[3]);

								$datosMedidor = array("diaLectura"=>$fecha[1], 
													   "mesLectura"=>$fecha[0], 
													   "anyoLectura"=>$fecha[2], 
													   "medidorFrontera"=>$data[2], 
													   "frontera_fronteraCliente"=>$data[0],
													   "tipoMedidor"=>"P",
													   "fechaCompleta"=>$data[3]);	
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
							  							  
															  
							if(!ModeloLogLectura::mdlIngresarLogLecturas($tabla,$datosLog,$datosMedidor,$datosLecturasEnergiaActiva,$datosLecturasEnergiaExportada,$datosLecturasEnergiaReactiva,$datosLecturasEnergiaCapacitiva))
							{
								echo ControladorUtilidades::answerScript("Ocurrio un error en el archivo","uploadConsumo");	 
	
							}

							}
							
						}
						fclose($handle);
						}
					  } 

				}

 
		}
	}
	/*=============================================
	MOSTRAR Lecturas
	=============================================*/

	static public function ctrMostrarLogLectura()
	{

		$tabla = "logLecturas";
		$item = NULL;
		$valor = NULL;
		return ModeloLogLectura::mdlMostrarLogLecturas($tabla,$item,$valor);
    

	}


	/*=============================================
	EDITAR Lecturas
	=============================================*/

	static public function ctrEditarFactura()
	{

		if(isset($_POST["editarnitCliente"]))
		{
				$tabla = "clienteFrontera";
			    $item = "contactoCliente";
				$item2 = "nitCliente";
				$item3 = "emailCliente";
				$item4 = "activo";
				$datos = array("nitCliente"=>$_POST["editarnitCliente"],"contactoCliente"=>$_POST["editarcontactoCliente"],"emailCliente"=>$_POST["editaremailCliente"],"activo"=>$_POST["editaractivo"]);
				$respuesta = ModeloClientesFrontera::mdlEditarClientes($tabla, $datos,$item,$item2,$item3,$item4);
				if($respuesta == "ok"){
					echo ControladorUtilidades::answerScript("¡El cliente ha sido guardado correctamente!","listadoClientes");	
				}
				else{
					echo ControladorUtilidades::answerBad($respuesta);
				}
		}
 
	}

	static public function ctrBorrarFactura($tabla,$item, $valor,$item1, $valor1,$item2, $valor2){

		return ModeloFactura::mdlBorrarFactura($tabla,$item, $valor,$item1, $valor1,$item2, $valor2);
	}

	static public function ctrSearchLogLectura($tabla,$item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3){

		return ModeloFactura::mdlSearchLogLectura($tabla,$item, $valor,$item1, $valor1,$item2, $valor2,$item3, $valor3);
	}


}

