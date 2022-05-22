<?php

require_once "conexion.php";

class ModeloPerfil{

	/*=============================================
	CREAR ITEM
	=============================================*/

	static public function mdlIngresarPerfil($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre,descripcion) VALUES (:nombre,:descripcion)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		//$stmt->bindParam(":TipoRespuesta_idTipoRespuesta", $datos["TipoRespuesta_idTipoRespuesta"], PDO::PARAM_INT);


		if($stmt->execute()){

		
			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	} 

	/*============================================= 
	MOSTRAR ITEMS
	=============================================*/

	static public function mdlMostrarPerfil($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();
			//return "SELECT * FROM $tabla WHERE $item = $valor";

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDITAR ITEM
	=============================================*/

	static public function mdlEditarPerfil($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, descripcion = :descripcion  WHERE idPerfilUsuarios = :idPerfilUsuarios");

		
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":idPerfilUsuarios", $datos["idPerfilUsuarios"], PDO::PARAM_INT);
 
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}


}