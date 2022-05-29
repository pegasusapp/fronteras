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
	BORRAR FACTURA
	=============================================*/

	static public function mdlBorrarFactura($tabla,$item, $valor, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item AND $item1 = :$item1 AND $item2 = :$item2");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);

        return $stmt -> execute(); 
		


	}


	static public function mdlSearchFactura($tabla,$item, $valor,$item1, $valor1,$item2, $valor2){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item1 = :$item1 AND $item2 = :$item2");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);
		$stmt -> execute();
		return $stmt->rowCount();
	}




}
