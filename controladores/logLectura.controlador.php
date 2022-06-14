<?php

class ControladorLogLectura
{



	static public function ctrCrearLogLectura()
	{
		
		echo "----->0";
		if(isset($_FILES["nameFile"]["name"]))
		{
				
			    $tabla = "logLecturas";
				/*=============================================
				VALIDAR SI EXISTE DOCUMENTO
				=============================================*/
				echo "----->1";
               
				$directorio = "docs/lecturas/";
				$target_file = $directorio."/".basename($_FILES["nameFile"]["name"]);
				if (!is_dir($directorio)) {
					mkdir($directorio, 0755,true);
				}
				echo "----->2";
				$filetype = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');

				if(!ControladorValidaciones::validateFile($_FILES["nameFile"]["tmp_name"],$filetype))
				{
					echo ControladorUtilidades::answerScript("El tipo de archivo que intenta subir no es permitido","uploadFile");	
						
				}
				echo "----->3";
				if ($_FILES["nameFile"]["size"] > Constantes::FILE_SIZE) {

					echo ControladorUtilidades::answerScript("El tipo de archivo que intenta subir es mayor a 5 MEGAS, baje el tamaño del archivo","uploadFile");	

				}
				echo "----->4";
				if (file_exists($directorio."/".$_FILES["nameFile"]["name"])){
					echo ControladorUtilidades::answerScript("El archivo que esta intentando subir ya existe,cambie el nombre del archivo","uploadFile");	
				  }
				  echo "----->5";
				if (move_uploaded_file($_FILES["nameFile"]["tmp_name"], $target_file)){
					echo "----->6";
					
					$datosLog = array("nameFile"=>$_FILES["nameFile"]["name"],
					"upload"=>0);

					 if(ModeloLogLectura::mdlIngresarLogLecturas($tabla,$datosLog))
					 {
						echo ControladorUtilidades::answerScript("Archivo subido correctamente","uploadFile");	

					 }
					 else{
						echo ControladorUtilidades::answerScript("Problemas al subir el archivo","uploadFile");	

					 }

					
					
					//Buscar primero si ya existen los registros



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

