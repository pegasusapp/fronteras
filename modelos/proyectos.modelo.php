<?php

require_once "conexion.php";

class ModeloProyectos{

	
	/*=============================================
	MOSTRAR ITEMS
	=============================================*/

	static public function mdlMostrarProyectos($tabla,$tabla2, $item, $valor)
	{

		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
			if($item != null)
			{
				$stmt = $pdo->prepare("SELECT  GROUP_CONCAT(fuenteEnergia_idfuenteEnergia) as fuentes,  idproyecto, nombrePlanta, ubicacionProyecto, fechaRegistro, tipoInstalacion,  
											   actividadComercial, gerentePlanta, nroContacto, correoContacto, jefeMantenimiento, contactoJefe, correoContactojefe,
											   municipio_idmunicipio,mu.departamento_iddepartamento,de.departamento,mu.nombreMunicipio,de.pais_idpais  
				                               FROM $tabla LEFT JOIN $tabla2 ON idproyecto = proyecto_idproyecto 
											   			   LEFT JOIN municipio mu ON  municipio_idmunicipio  = mu.idmunicipio
														   LEFT JOIN departamento de ON mu.departamento_iddepartamento = de.iddepartamento  
														   LEFT JOIN pais pa ON pa.idpais = de.pais_idpais 	  	
											   WHERE $item = :$item");
				$stmt ->bindParam(":".$item, $valor, PDO::PARAM_STR);
			}
			else
			{
				$stmt = $pdo->prepare("SELECT  idproyecto, nombrePlanta, ubicacionProyecto, fechaRegistro, tipoInstalacion,  
											   actividadComercial, gerentePlanta, nroContacto, correoContacto, jefeMantenimiento, contactoJefe, correoContactojefe,
											   municipio_idmunicipio,mu.departamento_iddepartamento,de.departamento,mu.nombreMunicipio,de.pais_idpais  
				                               FROM $tabla LEFT JOIN municipio mu ON  municipio_idmunicipio  = mu.idmunicipio
														   LEFT JOIN departamento de ON mu.departamento_iddepartamento = de.iddepartamento  
														   LEFT JOIN pais pa ON pa.idpais = de.pais_idpais");
			}
			$stmt ->execute();
			$pdo->commit();
		}
		catch (PDOException $ex) 
		{
				$pdo->rollBack();
				//return "Error presentado en: ".$ex->__toString();
				return "Error presentado en: ".$ex->getMessage();
		}
		return $stmt -> fetchAll(PDO::FETCH_ASSOC);
		$pdo = null;
	}

	static public function mdlMostrarProyectosAjax($tabla) 
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

	/*=============================================
	MOSTRAR PROYECTO SIMPLE
	=============================================*/

	static public function mdlMostrarProyectoSimple($tabla, $item, $valor,$item2,$valor2){

		if($item != null)
		{
 
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item2 = :$item2");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll(PDO::FETCH_ASSOC);
		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item2 = :$item2");
			$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);
			$stmt -> execute();

			return $stmt -> fetchAll(PDO::FETCH_ASSOC);

		}

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	MOSTRAR GRUPO PROYECTO SIMPLE
	=============================================*/

	static public function mdlMostrarGruposProyecto($tabla,$tabla2, $item, $valor,$relacion1,$relacion2){

		if($item != null){
 
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla2   WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla2");

			$stmt -> execute();

			return $stmt -> fetchAll(PDO::FETCH_ASSOC);

		}

		$stmt -> close();

		$stmt = null;

	}		
/*=============================================
	CONTAR PROYECTOS
	=============================================*/

	static public function mdlContarProyectos($tabla, $item, $valor){

		

			$stmt = Conexion::conectar()->prepare("SELECT  COUNT(*) as cantidad FROM $tabla ");
			

			$stmt -> execute();

			return $stmt -> fetchAll(PDO::FETCH_ASSOC);

		

		$stmt -> close();

		$stmt = null;

	}	
	/*=============================================
	MOSTRAR ITEMS EXTRA
	=============================================*/

	static public function mdlMostrarProyectosExtra($tabla,$tabla2,$tabla3, $item, $valor){

		

			$stmt = Conexion::conectar()->prepare("SELECT idfuenteEnergia,icon, nombreFuente,proyecto_idproyecto,nombrePlanta,fuenteEnergia_idfuenteEnergia FROM $tabla  LEFT JOIN $tabla2  ON fuenteEnergia_idfuenteEnergia = idfuenteEnergia LEFT JOIN $tabla3 on proyecto_idproyecto=idproyecto WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

			$stmt -> execute();

			return $stmt -> fetchAll(PDO::FETCH_ASSOC);

			$stmt -> close();

			$stmt = null;

	}
	/*=============================================
	EDITAR ITEM
	=============================================*/

	static public function mdlEditarProyecto($tabla, $datos,$datosf)
	{
		
		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
			$stmt =$pdo->prepare("UPDATE $tabla SET nombrePlanta =:nombrePlanta, ubicacionProyecto =:ubicacionProyecto, fechaRegistro =:fechaRegistro, tipoInstalacion =:tipoInstalacion, 
												nombreMunicipio =:nombreMunicipio, nombreDepartamento =:nombreDepartamento,actividadComercial =:actividadComercial,
												gerentePlanta =:gerentePlanta,nroContacto =:nroContacto,correoContacto =:correoContacto,jefeMantenimiento =:jefeMantenimiento,
												contactoJefe =:contactoJefe,correoContactojefe =:correoContactojefe,municipio_idmunicipio =:municipio_idmunicipio
												WHERE idproyecto = :idproyecto");
			$stmt -> execute($datos);
			$proyecto_val = $datos["idproyecto"];
			foreach($datosf["fuentes"] as $arg )
				{
					$stmt =$pdo->prepare("SELECT count(*) FROM fuenteenergia_has_proyecto WHERE proyecto_idproyecto = $proyecto_val and fuenteEnergia_idfuenteEnergia = $arg");
					$stmt->execute();
					$count = $stmt->fetchColumn();
					if ($count  == 0)
					{
						$stmt = $pdo->prepare("INSERT INTO fuenteenergia_has_proyecto(fuenteEnergia_idfuenteEnergia,proyecto_idproyecto) VALUES (:fuenteEnergia_idfuenteEnergia, :proyecto_idproyecto)");
						$stmt->bindParam(":fuenteEnergia_idfuenteEnergia", $arg, PDO::PARAM_INT);
						$stmt->bindParam(":proyecto_idproyecto", $proyecto_val, PDO::PARAM_INT);
						$stmt->execute();
				
					}
				}
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

	
/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	static public function mdlCrearProyecto($tabla, $datos){
		//$stmt = Conexion::conectar()->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombrePlanta, ubicacionProyecto, fechaRegistro, tipoInstalacion, nombreMunicipio, nombreDepartamento, actividadComercial, gerentePlanta, nroContacto, correoContacto, jefeMantenimiento, contactoJefe, correoContactojefe) VALUES (:nombrePlanta, :ubicacionProyecto, :fechaRegistro, :tipoInstalacion, :nombreMunicipio, :nombreDepartamento, :actividadComercial, :gerentePlanta, :nroContacto, :correoContacto, :jefeMantenimiento, :contactoJefe, :correoContactojefe)");
		
		$stmt->bindParam(":nombrePlanta", $datos["nombrePlanta"], PDO::PARAM_STR);
		$stmt->bindParam(":ubicacionProyecto", $datos["ubicacionProyecto"], PDO::PARAM_STR);
		$stmt->bindParam(":fechaRegistro", $datos["fechaRegistro"], PDO::PARAM_STR);
		$stmt->bindParam(":tipoInstalacion", $datos["tipoInstalacion"], PDO::PARAM_STR);
		$stmt->bindParam(":nombreMunicipio", $datos["nombreMunicipio"], PDO::PARAM_STR);
	    $stmt->bindParam(":nombreDepartamento", $datos["nombreDepartamento"], PDO::PARAM_STR);
	    $stmt->bindParam(":actividadComercial", $datos["actividadComercial"], PDO::PARAM_STR);
	    $stmt->bindParam(":gerentePlanta", $datos["gerentePlanta"], PDO::PARAM_STR);
	    $stmt->bindParam(":nroContacto", $datos["nroContacto"], PDO::PARAM_STR);
	    $stmt->bindParam(":correoContacto", $datos["correoContacto"], PDO::PARAM_STR);
	    $stmt->bindParam(":jefeMantenimiento", $datos["jefeMantenimiento"], PDO::PARAM_STR);
	    $stmt->bindParam(":contactoJefe", $datos["contactoJefe"], PDO::PARAM_STR);
	    $stmt->bindParam(":correoContactojefe", $datos["correoContactojefe"], PDO::PARAM_STR);
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
/*=============================================
	REGISTRO DE CONSUMO 
	=============================================*/

	static public function mdlCrearConsumo($tabla, $datos){
		//$stmt = Conexion::conectar()->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(anyo, mes, consumo, costo,indicador,fuenteEnergia_idfuenteEnergia, proyecto_idproyecto) VALUES (:anyo, :mes, :consumo, :costo, :indicador,:fuenteEnergia_idfuenteEnergia, :proyecto_idproyecto)");

		$stmt->bindParam(":anyo", $datos["anyo"], PDO::PARAM_INT);
		$stmt->bindParam(":mes", $datos["mes"], PDO::PARAM_INT);
		$stmt->bindParam(":consumo", $datos["consumo"], PDO::PARAM_STR);
		$stmt->bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
		$stmt->bindParam(":indicador", $datos["indicador"], PDO::PARAM_STR);
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