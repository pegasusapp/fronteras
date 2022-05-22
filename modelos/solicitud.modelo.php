<?php

require_once "conexion.php";

class ModeloSolicitud{

	/*=============================================
	CREAR ITEM
	=============================================*/

	static public function mdlIngresarSolicitud($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombreCategoriaPlantilla) VALUES (:nombreCategoriaPlantilla)");

		$stmt->bindParam(":nombreCategoriaPlantilla", $datos["nombreCategoriaPlantilla"], PDO::PARAM_STR);
		//$stmt->bindParam(":TipoRespuesta_idTipoRespuesta", $datos["TipoRespuesta_idTipoRespuesta"], PDO::PARAM_INT);


		if($stmt->execute()){

		
			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR ITEMS
	=============================================*/

	static public function mdlMostrarSolicitud($tabla_uno,$tabla_dos, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar_externo()->prepare("SELECT * FROM $tabla_uno WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar_externo()->prepare("SELECT * FROM $tabla_uno LEFT JOIN $tabla_dos ON estado_solicitud_idestado_solicitud=idestado_solicitud");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}
	static public function mdlMostrarSolicitudProyeccion($tabla_uno,$tabla_dos,$tabla_tres,$tabla_cuatro,$tabla_cinco,$tabla_seis,$tabla_siete,$item, $valor){

		if($item != null){

			$stmt = Conexion::conectar_externo()->prepare("SELECT solicitudes.*, estado_solicitud.*, proyeccionEnergia.*, proyeccionEnergia_ci.*, documento.*,$tabla_seis.transformador_codigo_transformador,$tabla_siete.capacidad_nominal FROM $tabla_uno LEFT JOIN $tabla_dos  ON estado_solicitud_idestado_solicitud=idestado_solicitud  LEFT JOIN $tabla_tres ON idsolicitudes=$tabla_tres.solicitudes_idsolicitudes LEFT JOIN $tabla_cuatro ON idsolicitudes=$tabla_cuatro.solicitudes_idsolicitudes LEFT JOIN $tabla_cinco ON idsolicitudes=$tabla_cinco.solicitudes_idsolicitudes LEFT JOIN $tabla_seis ON $tabla_uno.Usuario_niu=$tabla_seis.niu  LEFT JOIN $tabla_siete ON $tabla_seis.transformador_codigo_transformador=$tabla_siete.codigo_transformador WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();
           			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar_externo()->prepare("SELECT * FROM $tabla_uno LEFT JOIN $tabla_dos LEFT JOIN $tabla_tres ON estado_solicitud_idestado_solicitud=idestado_solicitud");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	EDITAR ITEM
	=============================================*/

	static public function mdlEditarSolicitud($tabla, $datos){

		$date_mysql = date("Y-m-d H:i:s");
		$stmt = Conexion::conectar_externo()->prepare("UPDATE $tabla SET estado_solicitud_idestado_solicitud = :estado_solicitud_idestado_solicitud, observaciones_empresa = :observaciones_empresa, fecha_actualizacion = :fecha_actualizacion  WHERE idsolicitudes = :idsolicitudes");

		

		$stmt->bindParam(":estado_solicitud_idestado_solicitud", $datos["estado_solicitud_idestado_solicitud"], PDO::PARAM_STR);
 		$stmt->bindParam(":observaciones_empresa", $datos["observaciones_empresa"], PDO::PARAM_STR);
 		$stmt->bindParam(":fecha_actualizacion", $date_mysql, PDO::PARAM_STR);
		$stmt->bindParam(":idsolicitudes", $datos["idsolicitudes"], PDO::PARAM_INT);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}


}