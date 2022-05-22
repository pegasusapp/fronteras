<?php

require_once "conexion.php";

class ModeloEstadoSolicitud{

	/*=============================================
	CREAR ITEM
	=============================================*/

	static public function mdlIngresarEstadoSolicitud($tabla, $datos){

		$stmt = Conexion::conectar_externo()->prepare("INSERT INTO $tabla(nombre) VALUES (:nombre)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
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

	static public function mdlMostrarEstadoSolicitud($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar_externo()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar_externo()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDITAR ITEM
	=============================================*/

	static public function mdlEditarEstadoSolicitud($tabla, $datos){

		$stmt = Conexion::conectar_externo()->prepare("UPDATE $tabla SET nombre = :nombre  WHERE idestado_solicitud = :idestado_solicitud");

		
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":idestado_solicitud", $datos["idestado_solicitud"], PDO::PARAM_INT);
 
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}


}