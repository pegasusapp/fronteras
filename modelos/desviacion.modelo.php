<?php

require_once "conexion.php";

class ModeloDesviacion{


	static public function mdlMostrarDesviacion($tabla, $item, $valor):array{

		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item = :$item order by iddesviacion desc limit 1 ");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch(PDO::FETCH_ASSOC);
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla order by iddesviacion desc limit 1");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
	}

	static public function mdlIngresarDesviacion($tabla,$datosLog): bool{
		try{
			$stmt =  Conexion::conectar()->prepare("INSERT INTO $tabla(vlrMaximo, vlrMinimo, fechaRegistro, fechaUpdate) VALUES (:vlrMaximo,:vlrMinimo,NOW(),NOW())");
			$stmt->bindParam(":vlrMaximo", $datosLog["vlrMaximo"], PDO::PARAM_INT);
			$stmt->bindParam(":vlrMinimo", $datosLog["vlrMinimo"], PDO::PARAM_INT);
			return $stmt->execute();
		}catch(Exception $e){
			echo $e->getMessage();
		}
		
	}




	static public function mdlSearchDesviacion($tabla,$item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> execute();
		return $stmt->rowCount();
	}


	static public function mdlEditDesviacion($tabla,$data): bool{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET vlrMinimo= :vlrMinimo,vlrMaximo= :vlrMaximo,fechaUpdate= :fechaUpdate WHERE iddesviacion =:iddesviacion");
		$stmt -> bindParam(":iddesviacion", $data["iddesviacion"], PDO::PARAM_INT);
		$stmt -> bindParam(":vlrMinimo",$data["vlrMinimo"],PDO::PARAM_INT);
		$stmt -> bindParam(":vlrMaximo",$data["vlrMaximo"],PDO::PARAM_INT);
		$stmt -> bindParam(":fechaUpdate",date('Y-m-d H:i:s'),PDO::PARAM_STR);
        return $stmt -> execute(); 
	}

}
