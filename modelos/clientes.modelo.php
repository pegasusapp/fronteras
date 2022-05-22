<?php

require_once "conexion.php";

class ModeloClientes{

	
	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/

	static public function mdlMostrarClientes($tabla)
	{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $datos;
    	   	$stmt = null;
	}
    /*=============================================
	MOSTRAR TOTALES INDIVIDUAL
	=============================================*/

	static public function mdlMostrarTotalesInd($tabla,$item,$valor)
	{

	

		$stmt = Conexion::conectar()->prepare("SELECT  * FROM $tabla tc 
														 WHERE $item = $valor");

	
		$stmt -> execute();

		return $stmt -> fetch();



	$stmt -> close();

	$stmt = null;

     }
	/*=============================================
	MOSTRAR TOTALES DASH COSTO
	=============================================*/

	static public function mdlMostrarTotalesResumen($tabla,$item){

	

		$stmt = Conexion::conectar()->prepare("SELECT  anyo, sum(costo)as total FROM $tabla  GROUP BY $item");

											   
		//$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		//$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();



	$stmt -> close();

	$stmt = null;

} 
 
	/*=============================================
	MOSTRAR TOTALES DASH CONSUMO
	=============================================*/

	static public function mdlMostrarTotalesResumenConsumo($tabla,$grupo1,$grupo2,$filtro,$item2,$valor2,$item3,$valor3){

	
		if($filtro == NULL)
		{
			$stmt = Conexion::conectar()->prepare("SELECT  anyo, sum(consumo) as total, fuenteEnergia_idfuenteEnergia FROM $tabla tc LEFT JOIN proyecto pr ON tc.proyecto_idproyecto = pr.idproyecto 
			                                      																	  WHERE $item2 = $valor2  and $item3 = $valor3
												                                                                      GROUP BY $grupo1");
		}
		else 
		{
			$stmt = Conexion::conectar()->prepare("SELECT  anyo, sum(consumo) as total, fuenteEnergia_idfuenteEnergia FROM $tabla WHERE $grupo2 = $filtro AND $item2 = $valor2  GROUP BY $grupo1,$grupo2");
		}
		

											   
		//$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		//$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();



	$stmt -> close();

	$stmt = null;

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

		$stmt->close();
		$stmt = null;

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