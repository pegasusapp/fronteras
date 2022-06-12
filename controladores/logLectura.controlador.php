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
				if(self::ctrSearchLogLectura($tabla,"anyo", $_POST["anyo"],"mes", $_POST["mes"],"dia", $_POST["dia"],"frontera_fronteraCliente", $_POST["idFrontera"]) > 0)
				{
					//update proceso
				}
				else{
                $folder = $_POST["anyo"].$_POST["mes"].$_POST["dia"];
				$directorio = "docs/lecturas/".$_POST["idFrontera"]."/".$folder;
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
								$datosLog = array("anyo"=>$_POST["anyo"],
												  "mes"=>$_POST["mes"],
								   				  "dia"=>$_POST["dia"],
								                  "frontera_fronteraCliente"=>$_POST["idFrontera"]);

								$fecha = explode("/",$data[3]);

								$datosMedidor = array("diaLectura"=>$fecha[1], 
													   "mesLectura"=>$fecha[0], 
													   "anyoLectura"=>$fecha[2], 
													   "medidorFrontera"=>$data[2], 
													   "frontera_fronteraCliente"=>$data[0],
													   "tipoMedidor"=>"P",
													   "fechaCompleta"=>$data[3]);	

								$datosLecturasEnergiaActiva = array(
															  "H1"=>$data[5], 
															  "H2"=>$data[6], 
															  "H3"=>$data[7], 
															  "H4"=>$data[8], 
															  "H5"=>$data[9], 
															  "H6"=>$data[10], 
															  "H7"=>$data[11], 
															  "H8"=>$data[12], 
															  "H9"=>$data[13], 
															  "H10"=>$data[14], 
															  "H11"=>$data[15], 
															  "H12"=>$data[16], 
															  "H13"=>$data[17], 
															  "H14"=>$data[18], 
															  "H15"=>$data[19], 
															  "H16"=>$data[20], 
															  "H17"=>$data[21], 
															  "H18"=>$data[22], 
															  "H19"=>$data[23], 
															  "H20"=>$data[24], 
															  "H21"=>$data[25], 
															  "H22"=>$data[26], 
															  "H23"=>$data[27], 
															  "H24"=>$data[28],
															  "tipoEnergia"=>"A");	

							 $datosLecturasEnergiaExportada = array(
															  "H1"=>$data[29], 
															  "H2"=>$data[30], 
															  "H3"=>$data[31], 
															  "H4"=>$data[32], 
															  "H5"=>$data[33], 
															  "H6"=>$data[34], 
															  "H7"=>$data[35], 
															  "H8"=>$data[36], 
															  "H9"=>$data[37], 
															  "H10"=>$data[38], 
															  "H11"=>$data[39], 
															  "H12"=>$data[40], 
															  "H13"=>$data[41], 
															  "H14"=>$data[42], 
															  "H15"=>$data[43], 
															  "H16"=>$data[44], 
															  "H17"=>$data[45], 
															  "H18"=>$data[46], 
															  "H19"=>$data[47], 
															  "H20"=>$data[48], 
															  "H21"=>$data[49], 
															  "H22"=>$data[50], 
															  "H23"=>$data[51], 
															  "H24"=>$data[52],
															  "tipoEnergia"=>"E");	

							 $datosLecturasEnergiaReactiva = array(
															  "H1"=>$data[53], 
															  "H2"=>$data[54], 
															  "H3"=>$data[55], 
															  "H4"=>$data[56], 
															  "H5"=>$data[57], 
															  "H6"=>$data[58], 
															  "H7"=>$data[59], 
															  "H8"=>$data[60], 
															  "H9"=>$data[61], 
															  "H10"=>$data[62], 
															  "H11"=>$data[63], 
															  "H12"=>$data[64], 
															  "H13"=>$data[65], 
															  "H14"=>$data[66], 
															  "H15"=>$data[67], 
															  "H16"=>$data[68], 
															  "H17"=>$data[69], 
															  "H18"=>$data[70], 
															  "H19"=>$data[71], 
															  "H20"=>$data[72], 
															  "H21"=>$data[73], 
															  "H22"=>$data[74], 
															  "H23"=>$data[75], 
															  "H24"=>$data[76],
															  "tipoEnergia"=>"R");	

							$datosLecturasEnergiaCapacitiva = array(
																"H1"=>$data[77], 
																"H2"=>$data[78], 
																"H3"=>$data[79], 
																"H4"=>$data[80], 
																"H5"=>$data[81], 
																"H6"=>$data[82], 
																"H7"=>$data[83], 
																"H8"=>$data[84], 
																"H9"=>$data[85], 
																"H10"=>$data[86], 
																"H11"=>$data[87], 
																"H12"=>$data[88], 
																"H13"=>$data[89], 
																"H14"=>$data[90], 
																"H15"=>$data[91], 
																"H16"=>$data[92], 
																"H17"=>$data[93], 
																"H18"=>$data[94], 
																"H19"=>$data[95], 
																"H20"=>$data[96], 
																"H21"=>$data[97], 
																"H22"=>$data[98], 
																"H23"=>$data[99], 
																"H24"=>$data[100],
																"tipoEnergia"=>"C");									  							  
															  
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
	MOSTRAR Facturas
	=============================================*/

	static public function ctrMostrarLogLectura()
	{

		$tabla = "logLecturas";
		$item = NULL;
		$valor = NULL;
		return ModeloLogLectura::mdlMostrarLogLecturas($tabla,$item,$valor);
    

	}


	/*=============================================
	EDITAR Facturas
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

