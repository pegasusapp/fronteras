<?php

require_once "conexion.php";

class ModeloClientes{



	static public function mdlMostrarClientes($tabla)
	{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	static public function mdlMostrarTotalesInd($tabla,$item,$valor)
	{

		$stmt = Conexion::conectar()->prepare("SELECT  * FROM $tabla tc WHERE $item = $valor");
		$stmt -> execute();
		return $stmt -> fetch();
    }
	/*=============================================
	MOSTRAR TOTALES DASH COSTO
	=============================================*/

	static public function mdlMostrarTotalesResumen($tabla,$item){

		$stmt = Conexion::conectar()->prepare("SELECT  anyo, sum(costo)as total FROM $tabla  GROUP BY $item");
		$stmt -> execute();
		return $stmt -> fetchAll();
}
	static public function mdlMostrarTotalesResumenConsumo($tabla,$grupo1,$grupo2,$filtro,$item2,$valor2,$item3,$valor3){

		if($filtro == NULL){
			$stmt = Conexion::conectar()->prepare("SELECT  anyo, sum(consumo) as total, fuenteEnergia_idfuenteEnergia FROM $tabla tc LEFT JOIN proyecto pr ON tc.proyecto_idproyecto = pr.idproyecto WHERE $item2 = $valor2  and $item3 = $valor3
                                                            GROUP BY $grupo1");
		}
		else{
			$stmt = Conexion::conectar()->prepare("SELECT  anyo, sum(consumo) as total, fuenteEnergia_idfuenteEnergia FROM $tabla WHERE $grupo2 = $filtro AND $item2 = $valor2  GROUP BY $grupo1,$grupo2");
		}
		$stmt -> execute();
		return $stmt -> fetchAll();
	}

	/*=============================================
	EDITAR TOTALES
	=============================================*/

	static public function mdlEditarTotales($tabla, $datos)
	{
		$stmt = Conexion::conectar()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  consumo =:consumo, costo =:costo , indicador =:indicador
												WHERE idtotalesConsumo = :idtotalesConsumo");


	    $stmt->bindParam(":consumo", $datos["consumo"], PDO::PARAM_STR);
		$stmt->bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
		$stmt->bindParam(":indicador", $datos["indicador"], PDO::PARAM_STR);
	    $stmt->bindParam(":idtotalesConsumo", $datos["idtotalesConsumo"], PDO::PARAM_INT);
		if($stmt->execute())
		{
			return "ok";

		}else{
			return "error";
		}

	}
/*=============================================
	REGISTRO DE CLIENTES
	=============================================*/

	static public function mdlCrearClientes($tabla, $datos)
	{

		try {
				$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombreClienteProyecto, emailCliente, telefonoCliente, identificacionCliente) VALUES (:nombreClienteProyecto, :emailCliente, :telefonoCliente, :identificacionCliente)");
				$stmt->execute($datos);
				$stmt = null;
				return "ok";
			}
		catch (PDOException $ex)
			{
				return  $ex->__toString();
			}
	}

}