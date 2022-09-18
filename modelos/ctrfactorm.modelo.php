<?php
require_once "conexion.php";

class ModeloCtrFactorM{


	static public function mdlMostrarctrFactorM($tabla, $item, $valor):array{

		if($valor != null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
	}


	static public function mdlMostrarctrFactorMLastThreMonths($tabla,$frontera):array{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla
													WHERE anyo = YEAR(date_sub(now(),interval 1 day))
													AND mes in (MONTH(date_sub(now(),interval 1 day)),MONTH(date_sub(now(),interval 1 day))-1,MONTH(date_sub(now(),interval 1 day))-2)
													AND frontera_fronteraCliente = :frontera_fronteraCliente");
			$stmt->bindParam(":frontera_fronteraCliente", $frontera, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}




	static public function mdlSearchData($dataIn,$tabla):int{
		$stmt = Conexion::conectar()->prepare("SELECT count(*) FROM $tabla WHERE anyo = :anyo AND mes = :mes AND tipoEnergia = :tipoEnergia  AND frontera_fronteraCliente = :frontera_fronteraCliente");
		$stmt->bindParam(":anyo", $dataIn["anyo"], PDO::PARAM_INT);
		$stmt->bindParam(":mes", $dataIn["mes"], PDO::PARAM_INT);
		$stmt->bindParam(":tipoEnergia", $dataIn["tipoEnergia"], PDO::PARAM_STR);
		$stmt->bindParam(":frontera_fronteraCliente", $dataIn["frontera_fronteraCliente"], PDO::PARAM_STR);
		$stmt -> execute();
		return  $stmt->fetchColumn();
	}

	static public function mdlIngresarctrFactorM($tabla,$datosLog): bool{
		$valores = array("anyo" =>$datosLog["anyo"],
						"mes"=>$datosLog["mes"],
						"factor"=>$datosLog["factor"],
						"total"=>$datosLog["total"],
						"tipoEnergia"=>$datosLog["tipoEnergia"],
						"frontera_fronteraCliente"=>$datosLog["frontera_fronteraCliente"],
						"dias"=>$datosLog["dias"]);
		if(self::mdlSearchData($valores,$tabla) == 0){
			$stmt =  Conexion::conectar()->prepare("INSERT INTO $tabla(anyo, mes, factor, total,tipoEnergia, frontera_fronteraCliente,dias) VALUES ( :anyo, :mes, :factor, :total, :tipoEnergia, :frontera_fronteraCliente, :dias)");
		}
		else{
			$stmt =  Conexion::conectar()->prepare("UPDATE $tabla SET  factor = :factor, total = :total, dias = :dias WHERE anyo = :anyo AND mes = :mes AND tipoEnergia = :tipoEnergia AND frontera_fronteraCliente = :frontera_fronteraCliente");
		}
			$stmt->bindParam(":factor", $datosLog["factor"], PDO::PARAM_INT);
			$stmt->bindParam(":total", $datosLog["total"], PDO::PARAM_STR);
			$stmt->bindParam(":anyo", $datosLog["anyo"], PDO::PARAM_INT);
			$stmt->bindParam(":mes", $datosLog["mes"], PDO::PARAM_INT);
			$stmt->bindParam(":frontera_fronteraCliente", $datosLog["frontera_fronteraCliente"], PDO::PARAM_STR);
			$stmt->bindParam(":tipoEnergia", $datosLog["tipoEnergia"], PDO::PARAM_STR);
			$stmt->bindParam(":dias", $datosLog["dias"], PDO::PARAM_INT);
			return $stmt->execute();
	}


}
