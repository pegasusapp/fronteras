<?php

require_once "conexion.php";

class ModeloClientesFrontera{

	
	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/

	static public function mdlMostrarClientesFronteras($tabla,$item,$valor)
	{
			
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
		    if($item == null)
			{
			    $stmt = $pdo->prepare("SELECT * FROM $tabla");
			}
			else
			{
				$stmt = $pdo->prepare("SELECT * FROM $tabla WHERE  $item = :$item");
				$stmt ->bindParam(":".$item, $valor, PDO::PARAM_STR);
			}
			
			$stmt ->execute();
			$pdo->commit();
		
		}
		catch (PDOException $ex) 
		{
				$pdo->rollBack();
				//return "Error presentado en: ".$ex->__toString();
				return "Error presentado en: ".$ex->getMessage();
		}
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
		$pdo = null;
	}
   
	/*=============================================
	EDITAR TOTALES
	=============================================*/

	static public function mdlEditarClientes($tabla, $datos,$item,$item2,$item3,$item4)
	{
		
		
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
			
				$stmt = $pdo->prepare("UPDATE $tabla SET $item = :$item,$item3 = :$item3,$item4 = :$item4 WHERE $item2 = :$item2");
				$stmt ->bindParam(":".$item, $datos["contactoCliente"], PDO::PARAM_STR);
				$stmt ->bindParam(":".$item3, $datos["emailCliente"], PDO::PARAM_STR);
				$stmt ->bindParam(":".$item4, $datos["activo"], PDO::PARAM_INT);
				$stmt ->bindParam(":".$item2, $datos["nitCliente"], PDO::PARAM_STR);
				$stmt ->execute();
				$pdo->commit();
		}
		catch (PDOException $ex) 
		{
				$pdo->rollBack();
				//return "Error presentado en: ".$ex->__toString();
				return "Error presentado en: ".$ex->getMessage();
		}
		return "ok";
		$pdo = null;

	}

	

}