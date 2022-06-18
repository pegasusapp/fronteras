<?php

class ControladorDesviacion
{



	static public function ctrCrearDesviacion(){
		
			if(isset($_POST["vlr_Minimo"])) 
			{
			    $table = "desviacion";

					$data = array("vlrMinimo"=>$_POST["vlr_Minimo"],"vlrMaximo"=>$_POST["vlr_Maximo"]);

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


	static public function ctrEditDesviacion(){
		if(isset($_POST["vlrMinimo"])) 
		{
			$table = "desviacion";

				$data = array("iddesviacion"=>$_POST["iddesviacion"],"vlrMinimo"=>$_POST["vlrMinimo"],"vlrMaximo"=>$_POST["vlrMaximo"]);

				 if(ModeloDesviacion::mdlEditDesviacion($table,$data)){
					echo ControladorUtilidades::answerScript("Datos editados correctamente","desviacion");	

				 }
				 else{
					echo ControladorUtilidades::answerScript("Problemas al editar datos","desviacion");	

				 }
		}
	}

}

