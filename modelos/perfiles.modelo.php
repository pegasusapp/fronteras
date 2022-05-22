<?php

require_once "conexion.php";

class ModeloPerfiles{

	
	/*=============================================
	MOSTRAR ITEMS
	=============================================*/

	static public function mdlMostrarPerfil($tabla,$tabla2, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla LEFT JOIN $tabla2 ON fuenteEnergia_idfuenteEnergia=idfuenteEnergia  WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla LEFT JOIN $tabla2 ON fuenteEnergia_idfuenteEnergia=idfuenteEnergia");

			$stmt -> execute();

			return $stmt -> fetchAll(PDO::FETCH_ASSOC);

		}

		$stmt -> close();

		$stmt = null;

	}
/*=============================================
	MOSTRAR ITEMS DASH TOTAL
	=============================================*/

	static public function mdlMostrarPerfilDash($tabla, $item, $valor){

	

			$stmt = Conexion::conectar()->prepare("SELECT count(*) as cantidad FROM $tabla   WHERE $item = $valor");

			//$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDITAR ITEM
	=============================================*/

	static public function mdlEditarPerfil($tabla, $datos)
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
	REGISTRO DE PERFIL
	=============================================*/

	static public function mdlCrearPerfil($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, fuenteEnergia_idfuenteEnergia) VALUES (:nombre, :fuenteEnergia_idfuenteEnergia)");
		
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":fuenteEnergia_idfuenteEnergia", $datos["fuenteEnergia_idfuenteEnergia"], PDO::PARAM_INT);
		
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