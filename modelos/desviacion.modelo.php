<?php

require_once "conexion.php";

class ModeloDesviacion{


	static public function mdlMostrarDesviacion($tabla, $item, $valor):array{

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

	static public function mdlIngresarDesviacion($tabla,$datosLog): bool{

		$stmt =  Conexion::conectar()->prepare("INSERT INTO $tabla(vlrMaximo, vlrMinimo, fechaRegistro, fechaUpdate) VALUES (:vlrMinimo,:vlrMaximo,NOW(),NOW())");
		$stmt->bindParam(":vlrMaximo", $datosLog["vlrMaximo"], PDO::PARAM_INT);
		$stmt->bindParam(":vlrMinimo", $datosLog["vlrMinimo"], PDO::PARAM_INT);
		return $stmt->execute();
		
	}




	static public function mdlSearchDesviacion($tabla,$item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> execute();
		return $stmt->rowCount();
	}


	static public function mdlEditDesviacion($tabla,$data): bool{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET vlrMinimo=:vlrMinimo,vlrMaximo=:vlrMaximo,fechUpdate=NOW() WHERE iddesviacion =:id");
		$stmt -> bindParam(":iddesviacion", $data["id"], PDO::PARAM_INT);
		$stmt -> bindParam(":vlrMinimo",$data["vlrMinimo"],PDO::PARAM_INT);
		$stmt -> bindParam(":vlrMaximo",$data["vlrMaximo"],PDO::PARAM_INT);
        return $stmt -> execute(); 
	}

}
