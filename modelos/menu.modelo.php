<?php
require_once "conexion.php";

class ModeloMenu
{


	public static function mdlMostrarMenu($valor)
	{

		if ($valor != null) {
			
			
			$sql = "Select Subproceso_idSubproceso from subproceso_has_usuario where Usuario_identificador='".$valor."'";
			$result = Conexion::conectar()->prepare($sql);
			$result->execute();
			$numberOfRows = $result->fetchColumn();

			if ($numberOfRows > 0) {
				$stmt = Conexion::conectar()->prepare("SELECT ser.idServicio as idServicio,GROUP_CONCAT(DISTINCT pro.idProceso)  as procesos_id,GROUP_CONCAT(CONCAT(pro.idProceso,'-',sub.idSubproceso)) as subprocesos_id,
															GROUP_CONCAT(sub.nombreSubproceso) as nombreSubproceso,GROUP_CONCAT(sub.plantillaSubproceso) as nombrePlantillas,
															GROUP_CONCAT(DISTINCT CONCAT(pro.nombreProceso,'*',pro.iconoProceso))  As proceso_nombre,'Servicio_has_Usuario' as tabla,
															ser.nombreServicio, ser.icono
														    FROM servicio ser LEFT JOIN  proceso pro on  ser.idServicio	=  pro.Servicio_idServicio
														                  LEFT JOIN subproceso sub on sub.Proceso_idProceso = pro.idProceso
																		  LEFT JOIN subproceso_has_usuario shu on shu.Subproceso_idSubproceso = sub.idSubproceso
																		  WHERE shu.Usuario_identificador = '".$valor."' and shu.activo=1
																		  GROUP BY ser.idServicio
																		  ORDER BY ser.nombreServicio");
																	
	
				$stmt -> execute();
				return $stmt -> fetchAll();
			} else {
				$stmt = Conexion::conectar()->prepare("SELECT ser.idServicio, ser.nombreServicio, GROUP_CONCAT(DISTINCT(pro.idProceso)) as idProceso, GROUP_CONCAT(DISTINCT(pro.nombreProceso)) as nombreProceso, GROUP_CONCAT(DISTINCT(sub.idSubproceso)) as  idSubProceso, GROUP_CONCAT( DISTINCT(sub.nombreSubproceso)) as nombreSubproceso,ser.icono,pro.iconoProceso
														    FROM servicio ser LEFT JOIN proceso pro on ser.idServicio = pro.Servicio_idServicio
															                  LEFT JOIN subproceso sub on sub.Proceso_idProceso = pro.idProceso
															                  GROUP BY ser.idServicio");
	
				$stmt -> execute();
				return $stmt -> fetchAll();
			}
		} else {

			$stmt = Conexion::conectar()->prepare("SELECT ser.idServicio As idServicio,GROUP_CONCAT(DISTINCT pro.idProceso)  As procesos_id,GROUP_CONCAT(CONCAT(pro.idProceso,'-',sub.idSubproceso)) As subprocesos_id,
													GROUP_CONCAT(sub.nombreSubproceso) As nombreSubproceso,GROUP_CONCAT(sub.plantillaSubproceso) As nombrePlantillas,GROUP_CONCAT(DISTINCT pro.nombreProceso)  As proceso_nombre,
													'Servicio_has_Usuario' As tabla,ser.nombreServicio, ser.icono,GROUP_CONCAT(pro.iconoProceso) As iconoProceso
													FROM servicio ser  LEFT JOIN  proceso pro ON ser.idServicio = pro.Servicio_idServicio
																	   LEFT JOIN  subproceso sub ON sub.Proceso_idProceso = pro.idProceso
																	   GROUP BY ser.idServicio
																	   ORDER BY ser.nombreServicio");
				$stmt -> execute();
				return $stmt -> fetchAll();
		}
	}

	public static function mdlEditarMenu($valor, $item)
	{

		try {
			$stmt = Conexion::conectar()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = Conexion::conectar()->prepare("Select shu.activo,shu.lectura,shu.escritura,GROUP_CONCAT(sub.nombreSubproceso) as nombreSub,GROUP_CONCAT(sub.plantillaSubproceso) as nombrePlantillas,phu.activo as activoProceso, phu.lectura as lecturaProceso, phu.escritura as escrituraProceso, (pro.nombreProceso),pro.plantillaProceso,shus.activo as activoServicio, shus.lectura as lecturaServicio, shus.escritura as escrituraServicio,ser.idServicio,'Servicio_has_Usuario' as tabla ,ser.nombreServicio, ser.plantillaServicio,ser.icono,pro.iconoProceso
			from subproceso_has_usuario shu left join subproceso sub on shu.Subproceso_idSubproceso = sub.idSubproceso
													 left join proceso_has_usuario phu on phu.Proceso_idProceso = sub.Proceso_idProceso
													 left join proceso pro  on phu.Proceso_idProceso = pro.idProceso
													 left join servicio_has_usuario shus  on shus.Servicio_idservicio=pro.Servicio_idServicio
													 left join servicio ser on shus.Servicio_idServicio = ser.idServicio
													 
													 where $item = :$item and shu.activo=1
													 group by ser.nombreServicio,  pro.nombreProceso
													 Order By ser.nombreServicio");

			$stmt -> bindParam(":Usuario_identificador" , $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();
		} catch (PDOException $e) {
			return  "Your fail message: " . $e->getMessage();
		}
	}
	
	
	public static function mdlExpandirMenu($valor)
	{
		try {

			$stmt = Conexion::conectar()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = Conexion::conectar()->prepare("SELECT  sub.idSubproceso,ser.idServicio,pro.idProceso,acc.subproceso_id
													FROM subproceso sub
														INNER JOIN proceso pro on sub.Proceso_idProceso=pro.idProceso
														INNER JOIN servicio ser on pro.Servicio_idServicio=ser.idServicio
														LEFT JOIN acciones acc on sub.idSubproceso=acc.subproceso_id
													WHERE plantillaSubproceso = '".$valor."' or plantillaAccion='".$valor."'
													order by ser.nombreServicio");

				$stmt -> execute();
				return $stmt -> fetchAll();
		} catch (PDOException $e) {
			return  "Your fail message: " . $e->getMessage();
		}
	}

	public static function mdlEditarMenuServicio($item, $valor1, $valor2)
	{

		try 
		{
	      
					if($valor1<>"")
					{
						$elementos_vector = explode(',', $valor1);
						$vector_servicios = array();
						$vector_procesos = array();
						$vector_subprocesos = array();
						foreach ($elementos_vector as $value)
						{
								$vector_separator = explode("-",$value); 
								if (!in_array($vector_separator[0], $vector_servicios)) {
									array_push($vector_servicios,$vector_separator[0]);
								}
								if (!in_array($vector_separator[1], $vector_procesos)) {
									array_push($vector_procesos,$vector_separator[1]);
								}
								if (!in_array($vector_separator[2], $vector_subprocesos)) {
									array_push($vector_subprocesos,$vector_separator[2]);
								}
								
								
								
						}
						$stmt_e = Conexion::conectar()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$stmt_e = Conexion::conectar()->prepare("SELECT * FROM subproceso_has_usuario WHERE Subproceso_idSubproceso NOT IN (".implode(",",$vector_subprocesos).") and $item = :$item");
						$stmt_e->execute([$item => $valor2]);
						$data_subprocesos = $stmt_e->fetchAll();
						
						foreach ($data_subprocesos as $valor_inactivar_subprocesos)
						{
							
							$valueOff=0;
							$stmt_down_subprocesos = Conexion::conectar()->prepare("UPDATE subproceso_has_usuario SET activo = :activo, lectura = :lectura, escritura = :escritura, fechaActualizacion = NOW() WHERE Subproceso_idSubproceso = :Subproceso_idSubproceso AND Usuario_identificador = :Usuario_identificador");
							$stmt_down_subprocesos->bindParam(":activo", $valueOff , PDO::PARAM_INT);
							$stmt_down_subprocesos->bindParam(":lectura", $valueOff , PDO::PARAM_INT);
							$stmt_down_subprocesos->bindParam(":escritura", $valueOff , PDO::PARAM_INT);
							$stmt_down_subprocesos->bindParam(":Subproceso_idSubproceso", $valor_inactivar_subprocesos["Subproceso_idSubproceso"], PDO::PARAM_INT);
							$stmt_down_subprocesos->bindParam(":Usuario_identificador", $valor2, PDO::PARAM_STR);
							$stmt_down_subprocesos->execute();
						}
						
						
						$stmt_down_subprocesos = null;
						$stmt_e = null;
						//Fin inhabilitar subprocesos
						//Habilitamos los subprocesos
						$valueOn=1;
						$stmt_f = Conexion::conectar()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						foreach ($vector_subprocesos as $id_subproceso_unitario ) {
							$stmt_f = Conexion::conectar()->prepare("SELECT * FROM subproceso_has_usuario WHERE Subproceso_idSubproceso=".$id_subproceso_unitario." and $item = :$item");
							$stmt_f->execute([$item => $valor2]);
							$data_f = $stmt_f->fetchAll();
							$cantidad_elementos = $stmt_f->rowCount();
							if ($cantidad_elementos > 0) {
								foreach ($data_f as $valor_activar_subprocesos)
									{
										    $stmt_up_subprocesos = Conexion::conectar()->prepare("UPDATE subproceso_has_usuario SET activo = :activo, lectura = :lectura, escritura = :escritura, fechaActualizacion = NOW() WHERE Subproceso_idSubproceso = :Subproceso_idSubproceso AND Usuario_identificador = :Usuario_identificador");
											$stmt_up_subprocesos->bindParam(":activo", $valueOn , PDO::PARAM_INT);
											$stmt_up_subprocesos->bindParam(":lectura", $valueOn , PDO::PARAM_INT);
											$stmt_up_subprocesos->bindParam(":escritura", $valueOn , PDO::PARAM_INT);
											$stmt_up_subprocesos->bindParam(":Subproceso_idSubproceso", $valor_activar_subprocesos["Subproceso_idSubproceso"], PDO::PARAM_INT);
											$stmt_up_subprocesos->bindParam(":Usuario_identificador", $valor2, PDO::PARAM_STR);
											$stmt_up_subprocesos->execute();
									
									}
							} else {
							  	            date_default_timezone_set('America/Bogota');
											$fecha = date('Y-m-d');
											$hora = date('H:i:s');
											$fechaActual = $fecha.' '.$hora;
											$stmt_up_subprocesos = Conexion::conectar()->prepare("INSERT INTO subproceso_has_usuario (Subproceso_idSubproceso, Usuario_identificador, activo, lectura, escritura, fechaActualizacion) VALUES (:Subproceso_idSubproceso, :Usuario_identificador, :activo, :lectura, :escritura, :fechaActualizacion)");
											$stmt_up_subprocesos->bindParam(":Subproceso_idSubproceso",$id_subproceso_unitario, PDO::PARAM_INT);
											$stmt_up_subprocesos->bindParam(":Usuario_identificador", $valor2, PDO::PARAM_STR);
											$stmt_up_subprocesos->bindParam(":activo", $valueOn , PDO::PARAM_INT);
											$stmt_up_subprocesos->bindParam(":lectura", $valueOn , PDO::PARAM_INT);
											$stmt_up_subprocesos->bindParam(":escritura", $valueOn , PDO::PARAM_INT);
											$stmt_up_subprocesos->bindParam(":fechaActualizacion", $fechaActual, PDO::PARAM_STR);
											$stmt_up_subprocesos->execute();
											

							}
						}
						

							$stmt_up_subprocesos = null;
							$stmt_f = null;
							return "ok";
					} else {
						$stmt_all_down = Conexion::conectar()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$stmt_all_down = Conexion::conectar()->prepare("SELECT * FROM servicio_has_usuario WHERE  $item = :$item");
						$stmt_all_down->execute([$item => $valor2]);
						$data_all_down = $stmt_all_down->fetchAll();
						$cont=0;
						foreach ($data_all_down as $valor_desactivar) {
								$cont++;		
								$valueOff=0;
								$stmt_all_down_service = Conexion::conectar()->prepare("UPDATE servicio_has_usuario SET activo = :activo, lectura = :lectura, escritura = :escritura, fechaActualizacion = NOW()  WHERE Servicio_idServicio = :Servicio_idServicio and  Usuario_identificador = :Usuario_identificador");
								$stmt_all_down_service->bindParam(":activo", $valueOff , PDO::PARAM_INT);
								$stmt_all_down_service->bindParam(":lectura", $valueOff , PDO::PARAM_INT);
								$stmt_all_down_service->bindParam(":escritura", $valueOff , PDO::PARAM_INT);
								$stmt_all_down_service->bindParam(":Servicio_idServicio", $valor_desactivar["Servicio_idServicio"], PDO::PARAM_INT);
								$stmt_all_down_service->bindParam(":Usuario_identificador", $valor2, PDO::PARAM_STR);
								$stmt_all_down_service->execute();
							
							}
						$stmt_all_down = null;
						$stmt_all_down_service = null; 
						return "ok";
					}	
					
		}
		catch (PDOException $e) {
			//error
			return  "Your fail message: " . $e->getMessage();
		}

		
	

		

	}




	



}
