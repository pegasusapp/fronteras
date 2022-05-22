<?php

require_once "conexion.php";

class ModeloAlterno{
 
	
	/*=============================================
	MOSTRAR FUENTES
	=============================================*/

	static public function mdlMostrarAlterno($tabla, $item, $valor)
	{



		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
			if($item != null)
			{
				$stmt =$pdo->prepare("SELECT * FROM $tabla  WHERE $item = :$item");
				$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
				$stmt -> execute();
				$pdo->commit();
				return $stmt->fetch(PDO::FETCH_ASSOC);
			
			}
			else
			{
				$stmt =$pdo->prepare("SELECT * FROM $tabla");
				$stmt -> execute();
				$pdo->commit();
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		
		}	
		catch (PDOException $ex) 
		{
			$pdo->rollBack();
			//return "Error presentado en: ".$ex->__toString();
			return "Error presentado en: ".$ex->getMessage();
		}
		//return $stmt->fetchAll(PDO::FETCH_ASSOC);
		$pdo = null;



	/*	if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll(PDO::FETCH_ASSOC);

		}

		$stmt -> close();

		$stmt = null;*/

	}
/*=============================================
	CONTAR ALTERNOS
	=============================================*/

	static public function mdlContarAlterno($tabla, $item, $valor){

		

		$stmt = Conexion::conectar()->prepare("SELECT  COUNT(*) as cantidad FROM $tabla ");
		

		$stmt -> execute();

		return $stmt -> fetchAll(PDO::FETCH_ASSOC);

	

	$stmt -> close();

	$stmt = null;

}	
	/*=============================================
	EDITAR ALTERNOS
	=============================================*/

	static public function mdlEditarAlterno($tabla, $datos)
	{

		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
			$stmt =$pdo->prepare("UPDATE   $tabla 
										   SET vlr_activa = :vlr_activa, 
										       vlr_factura = :vlr_factura, 
											   vlr_kvh = :vlr_kvh, 
											   m1 = :m1, 
											   m2 = :m2, 
											   m3 = :m3, 
											   m4 = :m4, 
											   m5 = :m5, 
											   m6 = :m6, 
											   m7 = :m7, 
											   m8 = :m8, 
											   m9 = :m9, 
											   m10 = :m10, 
											   m11 = :m11,
											   m12 = :m12,
											   prom_mes = :prom_mes,
											   mercado = :mercado
										   WHERE alternaempresa_id = :alternaempresa_id");
          			   
			$stmt -> execute($datos);
			$pdo->commit();
		
		}	
		catch (PDOException $ex) 
		{
			$pdo->rollBack();
			return "Error presentado en: ".$ex->__toString();
			//return "Error presentado en: ".$ex->getMessage();
		}
		return "ok";
		$pdo = null;

	}

	
/*=============================================
	REGISTRO DE FUENTE
	=============================================*/

	static public function mdlCrearAlterno($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombreFuente,unidadMedidaFuente) VALUES (:nombreFuente,:unidadMedidaFuente)");
		
		$stmt->bindParam(":nombreFuente", $datos["nombreFuente"], PDO::PARAM_STR);
		$stmt->bindParam(":unidadMedidaFuente", $datos["unidadMedidaFuente"], PDO::PARAM_STR);
		
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