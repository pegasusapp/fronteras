<?php

require_once "conexion.php";

class ModeloCtrFactorM{


	static public function mdlMostrarctrFactorM($tabla, $item, $valor):array{

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




	static public function mdlSearchData($dataIn):int{
        
		$stmt = Conexion::conectar()->prepare("SELECT count(*) FROM ctrfactorm WHERE anyo = :anyo AND mes = :mes  AND frontera_fronteraCliente = :frontera_fronteraCliente");
		$stmt->bindParam(":anyo", $dataIn["anyo"], PDO::PARAM_INT);
		$stmt->bindParam(":mes", $dataIn["mes"], PDO::PARAM_INT);
		$stmt->bindParam(":frontera_fronteraCliente", $dataIn["frontera_fronteraCliente"], PDO::PARAM_STR);
		$stmt -> execute();
		return  $stmt->fetchColumn();
	}

	static public function mdlIngresarctrFactorM($tabla,$datosLog): bool{
		
		$valores = array("anyo" =>$datosLog["anyo"], 
						 "mes"=>$datosLog["mes"],
						 "factor"=>$datosLog["factor"],
						 "total"=>$datosLog["total"],
						 "frontera_fronteraCliente"=>$datosLog["frontera_fronteraCliente"]);
		if(self::mdlSearchData($valores) == 0)
		{
			$stmt =  Conexion::conectar()->prepare("INSERT INTO $tabla(anyo, mes, factor, total, frontera_fronteraCliente) VALUES ( :anyo, :mes, :factor, :total, :frontera_fronteraCliente)");
			
		}
		else{
			$stmt =  Conexion::conectar()->prepare("UPDATE $tabla SET  factor = :factor, total = :total WHERE anyo = :anyo AND mes = :mes  AND frontera_fronteraCliente = :frontera_fronteraCliente");
		}	
		    $stmt->bindParam(":factor", $datosLog["factor"], PDO::PARAM_INT);
		    $stmt->bindParam(":total", $datosLog["total"], PDO::PARAM_STR);
			$stmt->bindParam(":anyo", $datosLog["anyo"], PDO::PARAM_INT);
			$stmt->bindParam(":mes", $datosLog["mes"], PDO::PARAM_INT);
			$stmt->bindParam(":frontera_fronteraCliente", $datosLog["frontera_fronteraCliente"], PDO::PARAM_STR);
			return $stmt->execute();		  
		


		
	}


}
