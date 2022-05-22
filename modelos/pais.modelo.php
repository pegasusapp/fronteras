<?php

require_once "conexion.php";

class ModeloPais
{

	
	/*=============================================
	MOSTRAR ITEMS
	=============================================*/

	static public function mdlMostrarPais($tabla,$item,$valor) 
	{
	
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
		$stmt -> execute();
		$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $datos;
		$stmt = null;

   }

   static public function mdlMostrarDepartamento($tabla,$item,$valor) 
	{
	
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();
		$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $datos;
		$stmt = null;

   }
   static public function mdlMostrarMunicipio($tabla,$item,$valor) 
	{
	
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();
		$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $datos;
		$stmt = null;

   }
	


}