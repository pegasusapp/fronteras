<?php

require_once "conexion.php";

class ModeloFactorM{


	static public function mdlMostrarFactorM($tabla, $item, $valor):array{

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

	static public function mdlIngresarFactorM($tabla,$datosLog): bool{
		$stmt =  Conexion::conectar()->prepare("INSERT INTO $tabla(fecha, tipoEnergia, cantidad, frontera_fronteraCliente) VALUES ( NOW(), :tipoEnergia, :cantidad, :frontera_fronteraCliente)");
		$stmt->bindParam(":tipoEnergia", $datosLog["tipoEnergia"], PDO::PARAM_STR);
		$stmt->bindParam(":cantidad", $datosLog["cantidad"], PDO::PARAM_INT);
		$stmt->bindParam(":frontera_fronteraCliente", $datosLog["frontera_fronteraCliente"], PDO::PARAM_STR);
		return $stmt->execute();
		
	}


}
