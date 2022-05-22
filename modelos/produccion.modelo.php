<?php

require_once "conexion.php";

class ModeloProduccion{

	 
	/*=============================================
	MOSTRAR PRODUCCION
	=============================================*/

	static public function mdlMostrarProduccion($tabla,$tabla2,$tabla3,$tabla4,$item1,$valor1,$item2,$valor2){

	

			$stmt = Conexion::conectar()->prepare("SELECT  * FROM $tabla pro LEFT JOIN $tabla2 py ON pro.proyecto_idproyecto=py.idproyecto  
															
			                                        		 WHERE $item1 = $valor1");
	
												   
			//$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
			//$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

	

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	MOSTRAR PRODUCCION GRAFICO
	=============================================*/ 

	static public function mdlMostrarProduccionGraficas($tabla,$tabla2,$tabla3,$tabla4,$item1,$item2,$valor1,$valor2){

    if($item1 != null)	
		{
		$stmt = Conexion::conectar()->prepare("SELECT p.anyo,p.mes,t.consumo,t.costo,p.toneladas,t.indicador, pr.nombrePlanta,fe.unidadMedidaFuente,fe.nombreFuente 
												FROM  $tabla p  LEFT JOIN $tabla2 t ON p.proyecto_idproyecto=t.proyecto_idproyecto AND p.anyo=t.anyo AND p.mes=t.mes
												LEFT JOIN $tabla3 pr ON p.proyecto_idproyecto=pr.idproyecto
												LEFT JOIN $tabla4 fe ON t.fuenteEnergia_idfuenteEnergia=fe.idfuenteEnergia 
												WHERE $item1=$valor1 and $item2=$valor2
												ORDER BY p.anyo,p.mes");

			
		
		}
		else
		{
			$stmt = Conexion::conectar()->prepare("SELECT p.anyo,p.mes,t.consumo,t.costo,p.toneladas,t.indicador,pr.nombrePlanta,fe.unidadMedidaFuente,fe.nombreFuente  
			FROM  $tabla p  LEFT JOIN $tabla2 t ON p.proyecto_idproyecto=t.proyecto_idproyecto AND p.anyo=t.anyo AND p.mes=t.mes
			LEFT JOIN $tabla3 pr ON p.proyecto_idproyecto=pr.idproyecto
			LEFT JOIN $tabla4 fe ON t.fuenteEnergia_idfuenteEnergia=fe.idfuenteEnergia
			WHERE  $item2=$valor2 
			ORDER BY p.anyo,p.mes");


		}
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;

}
	/*=============================================
	MOSTRAR PRODUCCION NETA
	=============================================*/

	static public function mdlMostrarProduccionNeta($tabla,$tabla2,$item1,$valor1){

	

		$stmt = Conexion::conectar()->prepare("SELECT p.anyo,(p.mes),p.toneladas as 'toneladas', pr.nombrePlanta 
											   FROM  $tabla p  LEFT JOIN $tabla2 pr ON p.proyecto_idproyecto=pr.idproyecto 
							 				   WHERE $item1=$valor1
							 				   ORDER BY p.anyo,p.mes");

											   
		

		$stmt -> execute();

		return $stmt -> fetchAll();



	$stmt -> close();

	$stmt = null;

}

	/*=============================================
	MOSTRAR PRODUCCION NETA DASH
	=============================================*/

	static public function mdlMostrarProduccionNetaDash($tabla,$item){

	

		$stmt = Conexion::conectar()->prepare("Select  anyo,sum(toneladas) as toneladas from   $tabla
											   group by $item");

											   
		

		$stmt -> execute();

		return $stmt -> fetchAll();



	$stmt -> close();

	$stmt = null;

}

   /*============================================= 
	MOSTRAR PRODUCCION GRAFICO DASH
	=============================================*/

	static public function mdlMostrarProduccionGraficasDash($tabla,$tabla2,$tabla3,$item,$valor,$item2,$valor2,$item3,$valor3){

			if($item == null or $item == "")
			{
				$stmt = Conexion::conectar()->prepare("SELECT p.anyo,p.mes,avg(t.indicador) as 'indicador',pr.nombrePlanta,fuenteEnergia_idfuenteEnergia 
				FROM  $tabla p  LEFT JOIN $tabla2 t ON p.proyecto_idproyecto=t.proyecto_idproyecto AND p.anyo=t.anyo AND p.mes=t.mes
				LEFT JOIN $tabla3 pr ON p.proyecto_idproyecto=pr.idproyecto  AND t.proyecto_idproyecto NOT IN (16)
				WHERE $item2 = $valor2 AND $item3 = $valor3
				GROUP BY p.anyo,p.mes
				ORDER BY p.anyo,p.mes");
			}
			else
			{
				$stmt = Conexion::conectar()->prepare("SELECT p.anyo,p.mes,(t.indicador) as 'indicador',pr.nombrePlanta,fuenteEnergia_idfuenteEnergia 
				FROM  $tabla p  LEFT JOIN $tabla2 t ON p.proyecto_idproyecto=t.proyecto_idproyecto  AND p.anyo=t.anyo AND p.mes=t.mes
				LEFT JOIN $tabla3 pr ON p.proyecto_idproyecto=pr.idproyecto AND t.proyecto_idproyecto NOT IN (16)
				WHERE $item = $valor and $item2 = $valor2
				GROUP BY p.anyo,p.mes
				ORDER BY p.anyo,p.mes");
			}

	
		
			
			
			$stmt -> execute();
			return $stmt -> fetchAll();
			$stmt -> close();
			$stmt = null;
	
	}

   /*============================================= 
	MOSTRAR PRODUCCION GRAFICO DASH INDIVIDUAL
	=============================================*/

	static public function mdlMostrarProduccionGraficasDashIndividual($tabla,$tabla2,$tabla3,$item,$valor){

		if($item == null or $item == "")
		{
			$stmt = Conexion::conectar()->prepare("SELECT p.anyo,GROUP_CONCAT(t.consumo,'-',p.toneladas) AS elementos 
												FROM  $tabla p  LEFT JOIN $tabla2 t ON p.proyecto_idproyecto=t.proyecto_idproyecto AND t.proyecto_idproyecto NOT IN (16) AND p.anyo=t.anyo AND p.mes=t.mes
												LEFT JOIN $tabla3 pr ON p.proyecto_idproyecto=pr.idproyecto
												GROUP BY p.anyo
												ORDER BY p.anyo,p.mes");
		}
		else
		{
			$stmt = Conexion::conectar()->prepare("SELECT p.anyo,GROUP_CONCAT(t.consumo,'-',p.toneladas) AS elementos 
			FROM  $tabla p  LEFT JOIN $tabla2 t ON p.proyecto_idproyecto=t.proyecto_idproyecto AND t.proyecto_idproyecto NOT IN (16) AND p.anyo=t.anyo AND p.mes=t.mes
			LEFT JOIN $tabla3 pr ON p.proyecto_idproyecto=pr.idproyecto
			WHERE $item = $valor
			GROUP BY p.anyo
			ORDER BY p.anyo,p.mes");
		}
	/*
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt ->fetchAll(PDO::FETCH_ASSOC);
		$stmt -> close();
		$stmt = null;*/
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;

}	

    /*============================================= 
	MOSTRAR MAX INDICADOR ENERGETICO
	=============================================*/

	static public function mdlMostrarProduccionIndicador($tabla,$tabla2,$tabla3,$tabla4,$fun,$item,$valor,$item2,$valor2,$item3,$valor3){

		if($item == null or $item == "")
		{
		    $stmt = Conexion::conectar()->prepare("SELECT p.anyo,MONTHNAME(STR_TO_DATE(p.mes, '%m')) as mes,avg(t.indicador) as avg_rate
													FROM  $tabla p  LEFT JOIN $tabla2 t ON p.proyecto_idproyecto=t.proyecto_idproyecto  AND t.proyecto_idproyecto NOT IN (16) AND p.anyo=t.anyo AND p.mes=t.mes
													LEFT JOIN $tabla3 pr ON p.proyecto_idproyecto=pr.idproyecto
													LEFT JOIN $tabla4 fe ON t.fuenteEnergia_idfuenteEnergia = fe.idfuenteEnergia
													WHERE $item2 = $valor2  AND t.proyecto_idproyecto NOT IN (16) AND $item3 = $valor3
													GROUP BY p.anyo,p.mes
													ORDER BY avg_rate ".$fun." 
													LIMIT 1");

											

	
		}
		else
		 {
			$stmt = Conexion::conectar()->prepare("SELECT p.anyo,MONTHNAME(STR_TO_DATE(p.mes, '%m')) as mes,(t.indicador) as avg_rate
													FROM  $tabla p  LEFT JOIN $tabla2 t ON p.proyecto_idproyecto=t.proyecto_idproyecto   AND p.anyo=t.anyo AND p.mes=t.mes
													LEFT JOIN $tabla3 pr ON p.proyecto_idproyecto=pr.idproyecto
													LEFT JOIN $tabla4 fe ON t.fuenteEnergia_idfuenteEnergia = fe.idfuenteEnergia
													WHERE $item = $valor AND $item2 = $valor2 AND t.proyecto_idproyecto NOT IN (16)
													GROUP BY p.anyo,p.mes
													ORDER BY avg_rate ".$fun." 
													LIMIT 1");
													
		}
		
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;

}

	/*=============================================
	EDITAR PRODUCCION
	=============================================*/

	static public function mdlEditarProduccion($tabla, $datos)
	{
		$stmt = Conexion::conectar()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET anyo =:anyo, mes =:mes, toneladas =:toneladas,  proyecto_idproyecto =:proyecto_idproyecto
				                                WHERE idproduccion = :idproduccion");

	    $stmt->bindParam(":anyo", $datos["anyo"], PDO::PARAM_INT);
	    $stmt->bindParam(":mes", $datos["mes"], PDO::PARAM_INT);
	    $stmt->bindParam(":toneladas", $datos["toneladas"], PDO::PARAM_STR);
	    $stmt->bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
	    $stmt->bindParam(":proyecto_idproyecto", $datos["proyecto_idproyecto"], PDO::PARAM_INT);
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
	REGISTRO DE PRODUCCION
	=============================================*/

	static public function mdlCrearProduccion($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(anyo, mes, toneladas, proyecto_idproyecto) VALUES (:anyo, :mes, :toneladas, :proyecto_idproyecto)");
		
		$stmt->bindParam(":anyo", $datos["anyo"], PDO::PARAM_INT);
		$stmt->bindParam(":mes", $datos["mes"], PDO::PARAM_INT);
		$stmt->bindParam(":toneladas", $datos["toneladas"], PDO::PARAM_STR);
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