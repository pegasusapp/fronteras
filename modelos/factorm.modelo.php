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

	static public function mdlReportDailyFactorM($tabla,$tipoEnergia,$dias,$frontera){
		$stmt = Conexion::conectar()->prepare("SELECT YEAR(fecha) as anyo,MONTH(fecha) as mes,frontera_fronteraCliente as frontera,tipoEnergia,sum(if(cantidad > 0 ,1,0)) as consumo,sum(if(cantidad = 0 ,1,0)) as no_consumo ,sum(cantidad) as cantidad FROM $tabla
												WHERE frontera_fronteraCliente = :frontera_fronteraCliente
												AND tipoEnergia = :tipoEnergia
												GROUP BY frontera_fronteraCliente,tipoEnergia,YEAR(fecha),MONTH(fecha)
												ORDER BY frontera_fronteraCliente");
				$stmt -> bindParam(":frontera_fronteraCliente", $frontera, PDO::PARAM_STR);
				$stmt -> bindParam(":tipoEnergia", $tipoEnergia, PDO::PARAM_STR);
				$stmt -> execute();
		return  $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}


	static public function mdlSearchData($dataIn):int{
		$stmt = Conexion::conectar()->prepare("SELECT count(*) FROM factorm WHERE fecha = :fecha AND tipoEnergia = :tipoEnergia  AND frontera_fronteraCliente = :frontera_fronteraCliente");
		$stmt -> bindParam(":fecha", $dataIn["fecha"], PDO::PARAM_STR);
		$stmt -> bindParam(":frontera_fronteraCliente", $dataIn["frontera_fronteraCliente"], PDO::PARAM_STR);
		$stmt -> bindParam(":tipoEnergia", $dataIn["tipoEnergia"], PDO::PARAM_STR);
		$stmt -> execute();
		return  $stmt->fetchColumn();
	}

	static public function mdlIngresarFactorM($tabla,$datosLog): bool{
		$valores = array("fecha" =>$datosLog["fecha"],"tipoEnergia"=>$datosLog["tipoEnergia"],"frontera_fronteraCliente"=>$datosLog["frontera_fronteraCliente"]);
		if(self::mdlSearchData($valores) == 0){
			$stmt =  Conexion::conectar()->prepare("INSERT INTO $tabla(fecha, tipoEnergia, cantidad, frontera_fronteraCliente) VALUES ( :fecha, :tipoEnergia, :cantidad, :frontera_fronteraCliente)");
		}
		else{
			$stmt =  Conexion::conectar()->prepare("UPDATE $tabla SET  cantidad = :cantidad WHERE fecha = :fecha AND tipoEnergia = :tipoEnergia  AND frontera_fronteraCliente = :frontera_fronteraCliente");
		}
			$stmt->bindParam(":fecha", $datosLog["fecha"], PDO::PARAM_STR);
			$stmt->bindParam(":tipoEnergia", $datosLog["tipoEnergia"], PDO::PARAM_STR);
			$stmt->bindParam(":cantidad", $datosLog["cantidad"], PDO::PARAM_STR);
			$stmt->bindParam(":frontera_fronteraCliente", $datosLog["frontera_fronteraCliente"], PDO::PARAM_STR);
			return $stmt->execute();
	}


}
