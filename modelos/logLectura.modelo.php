<?php

require_once "conexion.php";

class ModeloLogLectura{


	static public function mdlMostrarLogLecturas($tabla, $item, $valor){

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

	static public function mdlIngresarLogLecturas($tabla,$datosLog,$datosMedidor,$datosLecturasEnergiaActiva,$datosLecturasEnergiaExportada,$datosLecturasEnergiaReactiva,$datosLecturasEnergiaCapacitiva){

		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
			  $stmt = $pdo->prepare("INSERT INTO $tabla(anyo, mes, dia, frontera_fronteraCliente, fechaInsert, fechaUpdate) VALUES (:anyo, :mes, :dia, :frontera_fronteraCliente,NOW(),NOW())");
			  $stmt->execute($datosLog);

			  $result_activa = [$datosMedidor,...$datosLecturasEnergiaActiva];
			  $stmt = $pdo->prepare("INSERT INTO lecturaFrontera(diaLectura, mesLectura, anyoLectura, H1, H2, H3, H4, H5, H6, H7, H8, H9, H10, H11, H12, H13, H14, H15, H16, H17, H18, H19, H20, H21, H22, H23, H24, medidorFrontera, frontera_fronteraCliente, tipoEnergia, tipoMedidor, fechaCompleta) VALUES (:diaLectura, :mesLectura, :anyoLectura,:H1, :H2,:H3, :H4, :H5, :H6, :H7, :H8, :H9, :H10, :H11, :H12, :H13, :H14, :H15, :H16, :H17, :H18, :H19, :H20, :H21, :H22, :H23, :H24, :medidorFrontera, :frontera_fronteraCliente, :tipoEnergia, :tipoMedidor, :fechaCompleta)");
			  $stmt->execute($result_activa); 
			  
			  $result_exportada = [$datosMedidor,...$datosLecturasEnergiaExportada];
			  $stmt = $pdo->prepare("INSERT INTO lecturaFrontera(diaLectura, mesLectura, anyoLectura, H1, H2, H3, H4, H5, H6, H7, H8, H9, H10, H11, H12, H13, H14, H15, H16, H17, H18, H19, H20, H21, H22, H23, H24, medidorFrontera, frontera_fronteraCliente, tipoEnergia, tipoMedidor, fechaCompleta) VALUES (:diaLectura, :mesLectura, :anyoLectura,:H1, :H2,:H3, :H4, :H5, :H6, :H7, :H8, :H9, :H10, :H11, :H12, :H13, :H14, :H15, :H16, :H17, :H18, :H19, :H20, :H21, :H22, :H23, :H24, :medidorFrontera, :frontera_fronteraCliente, :tipoEnergia, :tipoMedidor, :fechaCompleta)");
			  $stmt->execute($result_exportada);

			  $result_reactiva = [$datosMedidor,...$datosLecturasEnergiaReactiva];
			  $stmt = $pdo->prepare("INSERT INTO lecturaFrontera(diaLectura, mesLectura, anyoLectura, H1, H2, H3, H4, H5, H6, H7, H8, H9, H10, H11, H12, H13, H14, H15, H16, H17, H18, H19, H20, H21, H22, H23, H24, medidorFrontera, frontera_fronteraCliente, tipoEnergia, tipoMedidor, fechaCompleta) VALUES (:diaLectura, :mesLectura, :anyoLectura,:H1, :H2,:H3, :H4, :H5, :H6, :H7, :H8, :H9, :H10, :H11, :H12, :H13, :H14, :H15, :H16, :H17, :H18, :H19, :H20, :H21, :H22, :H23, :H24, :medidorFrontera, :frontera_fronteraCliente, :tipoEnergia, :tipoMedidor, :fechaCompleta)");
			  $stmt->execute($result_reactiva);

			  $result_capacitiva = [$datosMedidor,...$datosLecturasEnergiaCapacitiva];
			  $stmt = $pdo->prepare("INSERT INTO lecturaFrontera(diaLectura, mesLectura, anyoLectura, H1, H2, H3, H4, H5, H6, H7, H8, H9, H10, H11, H12, H13, H14, H15, H16, H17, H18, H19, H20, H21, H22, H23, H24, medidorFrontera, frontera_fronteraCliente, tipoEnergia, tipoMedidor, fechaCompleta) VALUES (:diaLectura, :mesLectura, :anyoLectura,:H1, :H2,:H3, :H4, :H5, :H6, :H7, :H8, :H9, :H10, :H11, :H12, :H13, :H14, :H15, :H16, :H17, :H18, :H19, :H20, :H21, :H22, :H23, :H24, :medidorFrontera, :frontera_fronteraCliente, :tipoEnergia, :tipoMedidor, :fechaCompleta)");
			  $stmt->execute($result_capacitiva);


			  $pdo->commit();
		}		
		catch (PDOException $ex) 
			{
				$pdo->rollBack();
				return "Error presentado en: ".$ex->getMessage();
			}
		return true;		
   


	}

	static public function mdlBorrarLogLecturas($tabla,$item, $valor, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item AND $item1 = :$item1 AND $item2 = :$item2");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);

        return $stmt -> execute(); 
		


	}


	static public function mdlSearchLogLectura($tabla,$item, $valor,$item1, $valor1,$item2, $valor2,$item3,$valor3){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item1 = :$item1 AND $item2 = :$item2 AND $item3 = :$item3");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item3, $valor3, PDO::PARAM_INT);
		$stmt -> execute();
		return $stmt->rowCount();
	}

}
