<?php

class ControladorLogLectura
{



	static public function ctrCrearLogLectura(){
		
		if(isset($_FILES["nameFile"]["name"]))
		{
				
			    $tabla = "logLecturas";
				/*=============================================
				VALIDAR SI EXISTE DOCUMENTO
				=============================================*/
               
				$directorio = "docs/lecturas/";
				$target_file = $directorio."/".basename($_FILES["nameFile"]["name"]);
				if (!is_dir($directorio)) {
					mkdir($directorio, 0755,true);
				}
				$mimesPermitidos = array('text/plain','text/csv','text/tsv','application/vnd.ms-excel','text/x-csv','application/csv','text/x-comma-separated-values');
				$extPermitidas = array('csv','txt','tsv');

				if(!ControladorValidaciones::validateFile($_FILES['nameFile']['tmp_name'],$mimesPermitidos,$extPermitidas))
				{
					echo ControladorUtilidades::answerScript("El tipo de archivo que intenta subir no es permitido","uploadConsumo");	
					return false;	
				}
				if ($_FILES["nameFile"]["size"] > Constantes::FILE_SIZE) {

					echo ControladorUtilidades::answerScript("El tipo de archivo que intenta subir es mayor a 5 MEGAS, baje el tamaño del archivo","uploadConsumo");	
					return false;

				}
				if (file_exists($directorio."/".$_FILES["nameFile"]["name"])){
					echo ControladorUtilidades::answerScript("El archivo que esta intentando subir ya existe,cambie el nombre del archivo","uploadConsumo");	
					return false; 
				}
				if (move_uploaded_file($_FILES["nameFile"]["tmp_name"], $target_file)){
					
					$datosLog = array("nameFile"=>$_FILES["nameFile"]["name"],
					"upload"=>0);

					 if(ModeloLogLectura::mdlIngresarLogLecturas($tabla,$datosLog))
					 {
						echo ControladorUtilidades::answerScript("Archivo subido correctamente","uploadConsumo");	

					 }
					 else{
						echo ControladorUtilidades::answerScript("Problemas al subir el archivo","uploadConsumo");	

					 }
			}

		}
	}
	/*=============================================
	MOSTRAR Logs
	=============================================*/

	static public function ctrMostrarLogLectura():array
	{

		$tabla = "logLecturas";
		$item = NULL;
		$valor = NULL;
		return ModeloLogLectura::mdlMostrarLogLecturas($tabla,$item,$valor);
    

	}


	static public function ctrBorrarLogLectura($tabla,$item, $valor):bool{

		return ModeloLogLectura::mdlBorrarLogLecturas($tabla,$item,$valor);
	}


	static public function ctrEditLogLectura($tabla,$item, $valor):bool{

		return ModeloLogLectura::mdlEditLogLectura($tabla,$item, $valor);
	}

}
