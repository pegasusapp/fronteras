<?php

require_once "conexion.php";

class ModeloLogLectura{


	static public function mdlMostrarLogLecturas($tabla, $item, $valor){

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

	static public function mdlIngresarLogLecturas($tabla,$datosLog){

		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
			  $stmt = $pdo->prepare("INSERT INTO $tabla(fechaInsert, nameFile, upload) VALUES (NOW(),:nameFile,:upload)");
			  $stmt->execute($datosLog);
			  $pdo->commit();
		}		
		catch (PDOException $ex) 
			{
				$pdo->rollBack();
				return "Error presentado en: ".$ex->getMessage();
			}
		return true;		
   


	}

	static public function mdlBorrarLogLecturas($tabla,$item, $valor, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item AND $item1 = :$item1 AND $item2 = :$item2");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);

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
