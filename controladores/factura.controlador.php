<?php

class ControladorFactura
{


	/*=============================================
	CREAR Facturas
	=============================================*/

	static public function ctrCrearFactura()
	{
		if(isset($_POST["anyoFactura"]))
		{
				
			    $tabla = "facturas";
				/*=============================================
				VALIDAR SI EXISTE DOCUMENTO
				=============================================*/
				if(self::ctrSearchFactura($tabla,"anyo", $_POST["anyoFactura"],"mes", $_POST["mesFactura"],"frontera_fronteraCliente", $_POST["idFrontera"]) > 0)
				{
					echo ControladorUtilidades::answerScript("Ya existe un registro para estas condiciones","uploadFile");	
					return false;
				}

				/*=============================================
				VALIDAR DOCUMENTO
				=============================================*/
                $folder = $_POST["anyoFactura"].$_POST["mesFactura"];
				$directorio = "docs/facturas/".$_POST["idFrontera"]."/".$folder;
				$target_file = $directorio."/".basename($_FILES["nameFile"]["name"]);
				if (!is_dir($directorio)) {
					mkdir($directorio, 0755,true);
				}

				$filetype = array('application/pdf');

				
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
					
					$datos = array("anyo"=>$_POST["anyoFactura"],
								   "mes"=>$_POST["mesFactura"],
				   				   "nameFile"=>$_FILES["nameFile"]["name"],
								   "frontera_fronteraCliente"=>$_POST["idFrontera"]);
				    $respuesta = ModeloFactura::mdlIngresarFactura($tabla,$datos);
				    if($respuesta == "ok"){
						echo ControladorUtilidades::answerScript("Los datos han sido guardados correctamente","uploadFile");	 
				   
					} 

				  }  
		}
	}
	/*=============================================
	MOSTRAR Facturas
	=============================================*/

	static public function ctrMostrarFactura()
	{

		$tabla = "facturas";
		$item = NULL;
		$valor = NULL;
		return ModeloFactura::mdlMostrarFacturas($tabla,$item,$valor);
    

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

	static public function ctrSearchFactura($tabla,$item, $valor,$item1, $valor1,$item2, $valor2){

		return ModeloFactura::mdlSearchFactura($tabla,$item, $valor,$item1, $valor1,$item2, $valor2);
	}


}

