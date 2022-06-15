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
		if($stmt->execute())
		{
			return true;
		
		}
		
			return false;
	
			
	
	}

	static public function mdlBorrarLogLecturas($tabla,$item, $valor): bool{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

        return $stmt -> execute(); 
		


	}


	static public function mdlSearchLogLectura($tabla,$item, $valor,$item1, $valor1,$item2, $valor2,$item3,$valor3){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item1 = :$item1 AND $item2 = :$item2 AND $item3 = :$item3");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item3, $valor3, PDO::PARAM_INT);
		$stmt -> execute();
		return $stmt->rowCount();
	}

}
