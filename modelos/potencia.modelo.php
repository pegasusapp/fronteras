<?php

require_once "conexion.php";

class ModeloPotencias{

	
	/*=============================================
	MOSTRAR POTENCIAS
	=============================================*/

	static public function mdlMostrarPotencias($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla   WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ");

			$stmt -> execute();

			return $stmt -> fetchAll(PDO::FETCH_ASSOC);

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDITAR POTENCIAS
	=============================================*/

	static public function mdlEditarPotencia($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombrePotencia =:nombrePotencia, descripcionPotencia =:descripcionPotencia,unidad =:unidad
				                                WHERE idtipoPotencia = :idtipoPotencia");

		
		
		$stmt->bindParam(":nombrePotencia", $datos["nombrePotencia"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcionPotencia", $datos["descripcionPotencia"], PDO::PARAM_STR);
		$stmt->bindParam(":unidad", $datos["unidad"], PDO::PARAM_STR);
 		$stmt->bindParam(":idtipoPotencia", $datos["idtipoPotencia"], PDO::PARAM_INT);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	
/*=============================================
	REGISTRO DE POTENCIAS
	=============================================*/

	static public function mdlCrearPotencia($tabla,$tabla2, $datos,$datos_potencia){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombrePotencia, descripcionPotencia, unidad)
		                                        VALUES (:nombrePotencia, :descripcionPotencia, :unidad)");
		
		$stmt->bindParam(":nombrePotencia", $datos["nombrePotencia"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcionPotencia", $datos["descripcionPotencia"], PDO::PARAM_STR);
		$stmt->bindParam(":unidad", $datos["unidad"], PDO::PARAM_STR);
		
	
		
		if($stmt->execute())
			{
							return "ok";
					
			}
			else
			 {
				return "error";
		
			 }	
	

		$stmt->close();

		$stmt = null;

	}


}