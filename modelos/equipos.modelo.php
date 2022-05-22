<?php

require_once "conexion.php";

class ModeloEquipos{

	
	/*=============================================
	MOSTRAR ITEMS
	=============================================*/

	static public function mdlMostrarEquipos($tabla,$tabla2,$tabla3,$tabla4,$tabla5,$tabla6, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla LEFT JOIN $tabla2 ON  idequipo=equipo_idequipo 
			 															LEFT JOIN $tabla3 ON  tipoPotencia_idtipoPotencia =idtipoPotencia
																		LEFT JOIN $tabla4 ON  area_idarea=idarea
																		LEFT JOIN $tabla5 ON  proyecto_idproyecto=idproyecto 
																		LEFT JOIN $tabla6 ON  perfilEnergia_idperfilEnergia=idperfilEnergia
																		WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla LEFT JOIN $tabla2 ON  idequipo=equipo_idequipo 
																		LEFT JOIN $tabla3 ON  tipoPotencia_idtipoPotencia =idtipoPotencia
																		LEFT JOIN $tabla4 ON  area_idarea=idarea
																		LEFT JOIN $tabla5 ON  proyecto_idproyecto=idproyecto
																		LEFT JOIN $tabla6 ON  perfilEnergia_idperfilEnergia=idperfilEnergia");

			$stmt -> execute();

			return $stmt -> fetchAll(PDO::FETCH_ASSOC);

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	EDITAR ITEM
	=============================================*/

	static public function mdlEditarEquipos($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombreArea =:nombreArea, proyecto_idproyecto =:proyecto_idproyecto
				                                WHERE idarea = :idarea");

		
		
		$stmt->bindParam(":nombreArea", $datos["nombreArea"], PDO::PARAM_STR);
		$stmt->bindParam(":proyecto_idproyecto", $datos["proyecto_idproyecto"], PDO::PARAM_STR);
 		$stmt->bindParam(":idarea", $datos["idarea"], PDO::PARAM_INT);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	
/*=============================================
	REGISTRO DE EQUIPOS
	=============================================*/

	static public function mdlCrearEquipos($tabla,$tabla2, $datos,$datos_potencia)
	{
		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("INSERT INTO $tabla(nombreEquipo, area_idarea, unidades, horasUsoDia, diasUsoMes, perfilEnergia_idperfilEnergia,observaciones)
		                                        VALUES (:nombreEquipo, :area_idarea,:unidades, :horasUsoDia, :diasUsoMes, :perfilEnergia_idperfilEnergia,:observaciones)");
		
		$stmt->bindParam(":nombreEquipo", $datos["nombreEquipo"], PDO::PARAM_STR);
		$stmt->bindParam(":area_idarea", $datos["area_idarea"], PDO::PARAM_INT);
		$stmt->bindParam(":unidades", $datos["unidades"], PDO::PARAM_INT);
		$stmt->bindParam(":horasUsoDia", $datos["horasUsoDia"], PDO::PARAM_INT);
		$stmt->bindParam(":diasUsoMes", $datos["diasUsoMes"], PDO::PARAM_INT);
		$stmt->bindParam(":perfilEnergia_idperfilEnergia", $datos["perfilEnergia_idperfilEnergia"], PDO::PARAM_INT);
		$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
	
		
		if($stmt->execute())
			{
					//		return "ok";
					$id = $pdo->lastInsertId();
					$flag=false;
					foreach($datos_potencia as $valor)
								{
									$vlr_eht = explode("-", $valor);
									$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla2(equipo_idequipo, tipoPotencia_idtipoPotencia, cantidad)
																	VALUES(:equipo_idequipo, :tipoPotencia_idtipoPotencia, :cantidad)");
									$stmt->bindParam(":equipo_idequipo", $id, PDO::PARAM_INT);
									$stmt->bindParam(":tipoPotencia_idtipoPotencia", $vlr_eht[0], PDO::PARAM_INT);
									$stmt->bindParam(":cantidad", $vlr_eht[1], PDO::PARAM_STR);
									if(!$stmt->execute())
										{
											$flag=true;
											return "error";	
										}
								


								}
							if(!$flag)
							   {
									return "ok";
							   }	
								
			}								
			else
			 {
				return "error";
		
			 }	
	

		//$stmt->close();
		//$stmt->close();

		$stmt = null;
		//$stmt_eht = null;

	


}


}