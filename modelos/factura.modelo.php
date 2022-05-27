<?php

require_once "conexion.php";

class ModeloFactura{

	/*=============================================
	MOSTRAR FACTURAS
	=============================================*/

	static public function mdlMostrarFacturas($tabla, $item, $valor){

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


	
	
	/*=============================================
	REGISTRO DE FACTURA
	=============================================*/

	static public function mdlIngresarFactura($tabla, $datos){

		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
			  $stmt = $pdo->prepare("INSERT INTO $tabla(anyo, mes, nameFile, frontera_fronteraCliente) VALUES (:anyo, :mes, :nameFile, :frontera_fronteraCliente)");
			  $stmt->execute($datos);
		   	  $pdo->commit();
		}		
		catch (PDOException $ex) 
			{
				$pdo->rollBack();
				return "Error presentado en: ".$ex->getMessage();
			}
		return "ok";		
   


	}


	/*=============================================
	EDITAR FACTURA 
	=============================================*/

	static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error".$stmt->error;

		}

	}

	/*=============================================
	BORRAR FACTURA
	=============================================*/

	static public function mdlBorrarFactura($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}


	}




}
