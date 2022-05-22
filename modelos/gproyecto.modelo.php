<?php

require_once "conexion.php"; 

class ModelogProyecto
{
	
   /*=============================================
	REGISTRO DE PROYECTO
	=============================================*/

	static public function mdlCreargProyecto($tabla, $datos)
	{
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		
		try {
				$stmt = $pdo->prepare("INSERT INTO $tabla(nombregProyecto, descripcionProyecto, potenciagSistema, generacionaProyecto, energiaAutoconsumo, energiaExcedentes, tarifaAplicada, 
				                                          tarifaGenerada, trmDolar, impuestoRenta, depreciacion, ipc, dtf, interesBancario, clienteProyecto_idclienteProyecto, 
														  tipoproyecto_idtipoproyecto) 
				                                  VALUES (:nombregProyecto, :descripcionProyecto, :potenciagSistema, :generacionaProyecto, :energiaAutoconsumo, :energiaExcedentes, :tarifaAplicada, 
				                                          :tarifaGenerada, :trmDolar, :impuestoRenta, :depreciacion, :ipc, :dtf, :interesBancario, :clienteProyecto_idclienteProyecto, 
														  :tipoproyecto_idtipoproyecto)");
				$stmt->execute($datos);
				$pdo->commit();
			} 
			catch (PDOException $ex) 
			{
				$pdo->rollBack();
				return "Error presentado en: ".$ex->__toString();
				//return "Error presentado en: ".$ex->getMessage();
			}
			return "ok";
			$pdo = null;

	}
    
    static public function mdlCreargProyectoConcepto($tabla, $datos)
	{
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		
		
		try {
				$stmt = $pdo->prepare("INSERT INTO $tabla(nombreConcepto, valor, movimiento_idmovimiento, gproyecto_idgproyecto,fecha) 
				                                  VALUES (:nombreConcepto, :valor, :movimiento_idmovimiento, :gproyecto_idgproyecto, :fecha)");
				$stmt->execute($datos);
				$pdo->commit();
			} 
			catch (PDOException $ex) 
			{
				$pdo->rollBack();
				//return "Error presentado en: ".$ex->__toString();
				return "Error presentado en: ".$ex->getMessage();
			}
			return "ok";
			$pdo = null;

	}




	static public function mdlMostrargtProyectosAjax($tabla)
	{
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
			$stmt =$pdo->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			$pdo->commit();
		
		}	
		catch (PDOException $ex) 
		{
			$pdo->rollBack();
			//return "Error presentado en: ".$ex->__toString();
			return "Error presentado en: ".$ex->getMessage();
		}
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		$pdo = null;
	

	}

	static public function mdlMostrargtMovimientosAjax($tabla)
	{
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
			$stmt =$pdo->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			$pdo->commit();
		
		}	
		catch (PDOException $ex) 
		{
			$pdo->rollBack();
			//return "Error presentado en: ".$ex->__toString();
			return "Error presentado en: ".$ex->getMessage();
		}
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		$pdo = null;
	

	}

	static public function mdlMostrargProyectosAjax($tabla,$tabla2,$tabla3,$tabla4,$tabla5)
	{
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
			$stmt =$pdo->prepare("SELECT *,SUM(IF(naturaleza='+',concepto.valor,0)) AS total_ingreso,SUM(IF(naturaleza='-',concepto.valor,0)) AS total_egreso FROM $tabla LEFT JOIN $tabla2 ON $tabla.tipoproyecto_idtipoproyecto = $tabla2.idtipoproyecto
													   LEFT JOIN $tabla3 ON $tabla.clienteProyecto_idclienteProyecto = $tabla3.idclienteProyecto
													   LEFT JOIN $tabla4 ON $tabla.idgproyecto = $tabla4.gproyecto_idgproyecto
													   LEFT JOIN $tabla5 ON $tabla4.movimiento_idmovimiento = $tabla5.idmovimiento
													   GROUP BY idgproyecto");
			$stmt -> execute();
			$pdo->commit();
		
		}	
		catch (PDOException $ex) 
		{
			$pdo->rollBack();
			//return "Error presentado en: ".$ex->__toString();
			return "Error presentado en: ".$ex->getMessage();
		}
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		$pdo = null;
	

	}
	static public function mdlMostrargProyectosMovimientos($tabla,$tabla2,$tabla3,$item,$valor)
	{
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
			$stmt =$pdo->prepare("SELECT idgproyecto,idconcepto,nombreConcepto,naturaleza,nombreMovimiento,valor FROM $tabla LEFT JOIN $tabla2 ON $tabla.gproyecto_idgproyecto = $tabla2.idgproyecto
													   LEFT JOIN $tabla3 ON $tabla.movimiento_idmovimiento = $tabla3.idmovimiento
													   WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			$pdo->commit();
		
		}	
		catch (PDOException $ex) 
		{
			$pdo->rollBack();
			//return "Error presentado en: ".$ex->__toString();
			return "Error presentado en: ".$ex->getMessage();
		}
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		$pdo = null;
	

	}
	static public function mdlMostrargProyecto($item,$valor,$tabla,$tabla2,$tabla3)
	{
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
			$stmt =$pdo->prepare("SELECT idgproyecto,nombregProyecto, descripcionProyecto, potenciagSistema, generacionaProyecto, energiaAutoconsumo, energiaExcedentes, tarifaAplicada, tarifaGenerada, trmDolar, impuestoRenta, depreciacion, ipc, dtf, interesBancario, clienteProyecto_idclienteProyecto, tipoproyecto_idtipoproyecto
			                               FROM $tabla 
										   WHERE $item = :$item");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);													   
			$stmt -> execute();
			$pdo->commit();
		
		}	
		catch (PDOException $ex) 
		{
			$pdo->rollBack();
			//return "Error presentado en: ".$ex->__toString();
			return "Error presentado en: ".$ex->getMessage();
		}
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		$pdo = null;
	

	}
	
	static public function mdlEditargProyecto($tabla,$valor,$datos)
	{
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
			$stmt =$pdo->prepare("UPDATE   $tabla 
										   SET nombregProyecto = :nombregProyecto, 
											   descripcionProyecto = :descripcionProyecto, 
											   potenciagSistema = :potenciagSistema, 
											   generacionaProyecto = :generacionaProyecto, 
											   energiaAutoconsumo = :energiaAutoconsumo, 
											   energiaExcedentes = :energiaExcedentes, 
											   tarifaAplicada = :tarifaAplicada, 
											   tarifaGenerada = :tarifaGenerada, 
											   trmDolar = :trmDolar, 
											   impuestoRenta = :impuestoRenta, 
											   depreciacion = :depreciacion, 
											   ipc = :ipc, 
											   dtf = :dtf, 
											   interesBancario = :interesBancario, 
											   clienteProyecto_idclienteProyecto = :clienteProyecto_idclienteProyecto, 
											   tipoproyecto_idtipoproyecto = :tipoproyecto_idtipoproyecto
										   WHERE idgproyecto = :idgproyecto");
          			   
			$stmt -> execute($datos);
			$pdo->commit();
		
		}	
		catch (PDOException $ex) 
		{
			$pdo->rollBack();
			//return "Error presentado en: ".$ex->__toString();
			return "Error presentado en: ".$ex->getMessage();
		}
		return "ok";
		$pdo = null;
	

	}

	static public function mdlBorrarConcepto($tabla,$valor,$item,$usuario)
	{
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
			
			/*$nombre = "";
			$valor = "";
			$stmt =$pdo->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);													   
			$stmt -> execute();
			while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) 
			{
				$nombre = $row["nombreConcepto"];
				$valor = $row["valor"];
			}
		*/

		//------------------------------------------------------------------------//		
			$stmt = $pdo->prepare("DELETE FROM $tabla WHERE $item = :$item");
            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);													   
			$stmt -> execute();
		//------------------------------------------------------------------------//	
		/*	date_default_timezone_set('America/Bogota');
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;*/
		//------------------------------------------------------------------------//	
			/*$stmt = $pdo->prepare("INSERT INTO auditoriaConcepto(fecha, usuario, nombreConcepto, valor)
			  						    VALUES (:fecha, :usuario, :nombreConcepto, :valor)");
			$stmt->bindParam(':fecha', $fechaActual, PDO::PARAM_STR);
			$stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR); 
			$stmt->bindParam(':nombreConcepto', $nombre, PDO::PARAM_STR); 
			$stmt->bindParam(':valor', $valor, PDO::PARAM_STR);  
			$stmt->execute();*/
		//------------------------------------------------------------------------//	
			$pdo->commit();
		
		}	
		catch (PDOException $ex) 
		{
			$pdo->rollBack();
			return "Error presentado en: ".$ex->__toString();
			//return "Error presentado en: ".$ex->getMessage();
		}
		return "ok";
		$pdo = null;
	

	}
	


}