<?php

require_once "conexion.php";

class ModeloAreas{

	
	/*=============================================
	MOSTRAR ITEMS
	=============================================*/

	static public function mdlMostrarAreas($tabla,$tabla2, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla LEFT JOIN $tabla2 ON proyecto_idproyecto=idproyecto  WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla LEFT JOIN $tabla2 ON proyecto_idproyecto=idproyecto");

			$stmt -> execute();

			return $stmt -> fetchAll(PDO::FETCH_ASSOC);

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDITAR ITEM
	=============================================*/

	static public function mdlEditarArea($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombreArea =:nombreArea, proyecto_idproyecto =:proyecto_idproyecto
				                                WHERE idarea = :idarea");

		
		
		$stmt->bindParam(":nombreArea", $datos["nombreArea"], PDO::PARAM_STR);
		$stmt->bindParam(":proyecto_idproyecto", $datos["proyecto_idproyecto"], PDO::PARAM_STR);
 		$stmt->bindParam(":idarea", $datos["idarea"], PDO::PARAM_INT);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	
/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	static public function mdlCrearArea($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombreArea, proyecto_idproyecto) VALUES (:nombreArea, :proyecto_idproyecto)");
		
		$stmt->bindParam(":nombreArea", $datos["nombreArea"], PDO::PARAM_STR);
		$stmt->bindParam(":proyecto_idproyecto", $datos["proyecto_idproyecto"], PDO::PARAM_INT);
		
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