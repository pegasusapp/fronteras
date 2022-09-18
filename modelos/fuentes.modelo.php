<?php

require_once "conexion.php";

class ModeloFuentes{

	
	/*=============================================
	MOSTRAR FUENTES
	=============================================*/

	static public function mdlMostrarFuentes($tabla,$tabla2, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll(PDO::FETCH_ASSOC);

		}

		$stmt -> close();

		$stmt = null;

	}
/*=============================================
	CONTAR FUENTES
	=============================================*/

	static public function mdlContarFuentes($tabla, $item, $valor){

		

		$stmt = Conexion::conectar()->prepare("SELECT  COUNT(*) as cantidad FROM $tabla ");
		

		$stmt -> execute();

		return $stmt -> fetchAll(PDO::FETCH_ASSOC);

	

	$stmt -> close();

	$stmt = null;

}	
	/*=============================================
	EDITAR FUENTES
	=============================================*/

	static public function mdlEditarFuente($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombreFuente =:nombreFuente,unidadMedidaFuente =:unidadMedidaFuente WHERE idfuenteEnergia =:idfuenteEnergia");

		
		
		$stmt->bindParam(":nombreFuente", $datos["nombreFuente"], PDO::PARAM_STR);
		$stmt->bindParam(":unidadMedidaFuente", $datos["unidadMedidaFuente"], PDO::PARAM_STR);
		$stmt->bindParam(":idfuenteEnergia", $datos["idfuenteEnergia"], PDO::PARAM_INT);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	
/*=============================================
	REGISTRO DE FUENTE
	=============================================*/

	static public function mdlCrearFuente($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombreFuente,unidadMedidaFuente) VALUES (:nombreFuente,:unidadMedidaFuente)");
		
		$stmt->bindParam(":nombreFuente", $datos["nombreFuente"], PDO::PARAM_STR);
		$stmt->bindParam(":unidadMedidaFuente", $datos["unidadMedidaFuente"], PDO::PARAM_STR);
		
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

/*=============================================
	REGISTRO DE FUENTE - PROYECTO
	=============================================*/

	static public function mdlMostrarFuenteProyecto($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll(PDO::FETCH_ASSOC);

		}

		$stmt -> close();

		$stmt = null;

	}


}