<?php

class ControladorDesviacion
{



	static public function ctrCrearDesviacion(){
		
			if(isset($_POST['submit'])) 
			{
				
			    $table = "desviacion";

					$data = array("vlrMinimo"=>$_POST["vlrMinimo"],"vlrMaximo"=>$_POST["vlrMaximo"]);

					 if(ModeloDesviacion::mdlIngresarDesviacion($table,$data)){
						echo ControladorUtilidades::answerScript("Datos insertados correctamente","desviacion");	

					 }
					 else{
						echo ControladorUtilidades::answerScript("Problemas al insertar datos","desviacion");	

					 }
			}

		}
	
	/*=============================================
	MOSTRAR DESVIACION
	=============================================*/

	static public function ctrMostrarDesviacion($item,$valor):array
	{

		$tabla = "desviacion";
		return ModeloDesviacion::mdlMostrarDesviacion($tabla,$item,$valor);
    

	}


	static public function ctrEditDesviacion($tabla,$data):bool{

		return ModeloLogLectura::mdlEditLogLectura($tabla,$data);
	}

}

