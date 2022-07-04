<?php

require_once "conexion.php";

class ModeloLogLecturaWS{


	static public function mdlMostrarLogLecturaWS($tabla, $item, $valor):array{

		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
	}

	static public function mdlIngresarLogLecturaWS($tabla,$datosLog): bool{
		$stmt =  Conexion::conectar()->prepare("INSERT INTO $tabla(fechaLectura, frontera, resultado, fechaInsert) VALUES ( :fechaLectura, :frontera, :resultado, NOW())");
		$stmt->bindParam(":fechaLectura", $datosLog["fechaLectura"], PDO::PARAM_STR);
		$stmt->bindParam(":frontera", $datosLog["frontera"], PDO::PARAM_STR);
		$stmt->bindParam(":resultado", $datosLog["resultado"], PDO::PARAM_STR);
		return $stmt->execute();
		
	}


}
