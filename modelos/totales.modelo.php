<?php

require_once "conexion.php";

class ModeloTotales{

	
	/*=============================================
	MOSTRAR TOTALES
	=============================================*/

	static public function mdlMostrarTotales($tabla,$tabla2,$tabla3,$tabla4,$item1,$valor1,$item2,$valor2,$orden){

	

			$stmt = Conexion::conectar()->prepare("SELECT  * FROM $tabla tc 
															 LEFT JOIN $tabla2 fhp ON tc.fuenteEnergia_idfuenteEnergia=fhp.fuenteEnergia_idfuenteEnergia and tc.proyecto_idproyecto=fhp.proyecto_idproyecto 
															 LEFT JOIN $tabla3 p ON fhp.proyecto_idproyecto = p.idproyecto
															 LEFT JOIN $tabla4 fe ON fhp.fuenteEnergia_idfuenteEnergia=fe.idfuenteEnergia
															 WHERE $item1 = $valor1 and $item2 = $valor2
															 ORDER BY $orden DESC");
	
		
			$stmt -> execute();

			return $stmt -> fetchAll();
        

	

		$stmt -> close();

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
	REGISTRO DE TOTALES
	=============================================*/

	static public function mdlCrearTotales($tabla, $datos){
		//$stmt = Conexion::conectar()->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(anyo, mes, consumo, costo, fuenteEnergia_idfuenteEnergia, proyecto_idproyecto) VALUES (:idtotalesConsumo, :anyo, :mes, :consumo, :costo, :fuenteEnergia_idfuenteEnergia, :proyecto_idproyecto)");
		
		$stmt->bindParam(":anyo", $datos["anyo"], PDO::PARAM_INT);
		$stmt->bindParam(":mes", $datos["mes"], PDO::PARAM_INT);
		$stmt->bindParam(":consumo", $datos["consumo"], PDO::PARAM_INT);
		$stmt->bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
		$stmt->bindParam(":fuenteEnergia_idfuenteEnergia", $datos["fuenteEnergia_idfuenteEnergia"], PDO::PARAM_INT);
	    $stmt->bindParam(":proyecto_idproyecto", $datos["proyecto_idproyecto"], PDO::PARAM_INT);
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