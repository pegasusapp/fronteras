<?php

require_once "conexion.php";

class ModeloLogLectura{


	static public function mdlMostrarLogLecturas($tabla, $item, $valor):array{

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

	static public function mdlIngresarLogLecturas($tabla,$datosLog): bool{

		$stmt =  Conexion::conectar()->prepare("INSERT INTO $tabla(fechaInsert, nameFile, upload) VALUES (NOW(),:nameFile,:upload)");
		$stmt->bindParam(":nameFile", $datosLog["nameFile"], PDO::PARAM_STR);
		$stmt->bindParam(":upload", $datosLog["upload"], PDO::PARAM_INT);
		return $stmt->execute();
		
	}

	static public function mdlBorrarLogLecturas($tabla,$item, $valor): bool{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
        return $stmt -> execute(); 
	}


	static public function mdlSearchLogLectura($tabla,$item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> execute();
		return $stmt->rowCount();
	}


	static public function mdlEditLogLectura($tabla,$item, $valor): bool{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET upload=1 WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
        return $stmt -> execute(); 
	}

}
