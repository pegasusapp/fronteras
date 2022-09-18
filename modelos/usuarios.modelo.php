<?php

require_once "conexion.php";

class ModeloUsuarios{

	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/

	static public function mdlMostrarUsuarios($tabla, $item, $valor){

		

		if($item != null){
			$stmt = Conexion::conectar()->prepare("SELECT identificador,nombreCompleto,celular,perfilusuarios.idPerfilUsuarios,estado,email,salt,password,perfilusuarios.nombre,nuevaFoto,proyecto_id FROM $tabla left join perfilusuarios on usuario.PerfilUsuarios_idPerfilUsuarios=perfilusuarios.idPerfilUsuarios WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();

		}else{
			$stmt = Conexion::conectar()->prepare("SELECT identificador,nombreCompleto,celular,nombre,estado,email,salt,password,perfilusuarios.nombre,nuevaFoto,proyecto_id FROM $tabla left join perfilusuarios on usuario.PerfilUsuarios_idPerfilUsuarios=perfilusuarios.idPerfilUsuarios");
			$stmt -> execute();
			return $stmt -> fetchAll();

		}
	
	}


	
	
	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	static public function mdlIngresarUsuario($tabla, $datos){

		$pdo = Conexion::conectar();
		$pdo ->beginTransaction();
		try 
		{
			  $stmt = $pdo->prepare("INSERT INTO $tabla(identificador, password, estado, email, salt, ultimo_login, celular, nombreCompleto,PerfilUsuarios_idPerfilUsuarios,nuevaFoto) VALUES (:identificador, :password, :estado, :email, :salt, :ultimo_login, :celular, :nombreCompleto, :PerfilUsuarios_idPerfilUsuarios, :nuevaFoto)");
			  $stmt->execute($datos);
			  $stmt = $pdo->prepare("INSERT INTO subproceso_has_usuario(Subproceso_idSubproceso, Usuario_identificador, activo, lectura, escritura, fechaActualizacion) VALUES (?, ?, ?, ?, ?, ?)");
			  $fecha = date('Y-m-d');
			  $hora =  date('H:i:s');  
			  $fechaActual = $fecha.' '.$hora; 
			
			  if($datos["PerfilUsuarios_idPerfilUsuarios"] == 10)
			   {
					$stmt->execute([13,$datos["identificador"],1,1,1,$fechaActual]);
					$stmt->execute([14,$datos["identificador"],1,1,1,$fechaActual]);
					$stmt->execute([15,$datos["identificador"],1,1,1,$fechaActual]);
					$stmt->execute([16,$datos["identificador"],1,1,1,$fechaActual]);
					$stmt->execute([17,$datos["identificador"],1,1,1,$fechaActual]);
					$stmt->execute([18,$datos["identificador"],1,1,1,$fechaActual]);
					$stmt->execute([19,$datos["identificador"],1,1,1,$fechaActual]);
					$stmt->execute([21,$datos["identificador"],1,1,1,$fechaActual]);
			   }
			  else 
			  {
					$stmt->execute([13,$datos["identificador"],1,1,1,$fechaActual]);
					$stmt->execute([14,$datos["identificador"],1,1,1,$fechaActual]);
					$stmt->execute([15,$datos["identificador"],1,1,1,$fechaActual]);
					$stmt->execute([16,$datos["identificador"],1,1,1,$fechaActual]);
					$stmt->execute([17,$datos["identificador"],1,1,1,$fechaActual]);
					$stmt->execute([18,$datos["identificador"],1,1,1,$fechaActual]);
					$stmt->execute([19,$datos["identificador"],1,1,1,$fechaActual]);
					$stmt->execute([20,$datos["identificador"],1,1,1,$fechaActual]);
					$stmt->execute([21,$datos["identificador"],1,1,1,$fechaActual]);
					$stmt->execute([22,$datos["identificador"],1,1,1,$fechaActual]);
			  }

			$pdo->commit();
		}		
		catch (PDOException $ex) 
			{
				$pdo->rollBack();
				return "Error presentado en: ".$ex->getMessage();
			}
		return "ok";		

	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function mdlEditarUsuario($tabla, $datos){

	
	try
	{
		if(isset($datos["password"]))
		{
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET password = :password, estado = :estado, email = :email, salt = :salt, PerfilUsuarios_idPerfilUsuarios = :PerfilUsuarios_idPerfilUsuarios, celular = :celular, nombreCompleto = :nombreCompleto, nuevaFoto = :nuevaFoto WHERE identificador = :identificador");
		   $stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		   $stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
		   $stmt -> bindParam(":email", $datos["email"], PDO::PARAM_STR);
		   $stmt -> bindParam(":salt", $datos["salt"], PDO::PARAM_STR);
		   $stmt -> bindParam(":PerfilUsuarios_idPerfilUsuarios", $datos["idPerfilUsuarios"], PDO::PARAM_INT);
		   $stmt -> bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
		   $stmt -> bindParam(":nombreCompleto", $datos["nombreCompleto"], PDO::PARAM_STR);
		   $stmt -> bindParam(':nuevaFoto', $datos["nuevaFoto"], PDO::PARAM_LOB);
		   $stmt -> bindParam(":identificador", $datos["identificador"], PDO::PARAM_STR);
   
		}
		else
		{ 
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  estado = :estado, email = :email, PerfilUsuarios_idPerfilUsuarios = :PerfilUsuarios_idPerfilUsuarios, celular = :celular, nombreCompleto = :nombreCompleto, nuevaFoto = :nuevaFoto WHERE identificador = :identificador");
	   
		   $stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
		   $stmt -> bindParam(":email", $datos["email"], PDO::PARAM_STR);
		   $stmt -> bindParam(":PerfilUsuarios_idPerfilUsuarios", $datos["idPerfilUsuarios"], PDO::PARAM_INT);
		   $stmt -> bindParam(":celular", $datos["celular"], PDO::PARAM_STR);
		   $stmt -> bindParam(":nombreCompleto", $datos["nombreCompleto"], PDO::PARAM_STR);
		   $stmt -> bindParam(':nuevaFoto', $datos["nuevaFoto"], PDO::PARAM_LOB);
		   $stmt -> bindParam(":identificador", $datos["identificador"], PDO::PARAM_STR);
   
		}

		
		if($_SESSION['identificador']==$datos["identificador"])
		{
			$_SESSION['nuevaFoto'] =  $datos["nuevaFoto"];
		}
		if($stmt -> execute()){ return "ok"; }else{ return "error";} 
		$stmt -> close();
		$stmt = null;

		
	} 
	catch(PDOException $e) 
	 {
	    return	 "An error occured: " . $e -> getMessage();
	 }
	}


	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/

	static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error".$stmt->error;

		}

	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function mdlBorrarUsuario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return "error";

		}
	}


	/*=============================================
	ACCESO DE USUARIO
	=============================================*/

	static public function mdlAccesoUsuario($tabla,$datosAcceso){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(horaIngreso, horaSalida, dirIP, navegador, nroSesion, Usuario_identificador) VALUES (:horaIngreso, :horaSalida, :dirIP, :navegador, :nroSesion, :Usuario_identificador)");

		$stmt->bindParam(":horaIngreso", $datosAcceso["horaIngreso"], PDO::PARAM_STR);
		$stmt->bindParam(":horaSalida", $datosAcceso["horaSalida"], PDO::PARAM_STR);
		$stmt->bindParam(":dirIP", $datosAcceso["dirIP"], PDO::PARAM_STR);
		$stmt->bindParam(":navegador", $datosAcceso["navegador"], PDO::PARAM_STR);
		$stmt->bindParam(":nroSesion", $datosAcceso["nroSesion"], PDO::PARAM_STR);
		$stmt->bindParam(":Usuario_identificador", $datosAcceso["Usuario_identificador"], PDO::PARAM_STR);
		


		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}
	}
	/*=============================================
	SALIDA DE USUARIO
	=============================================*/

	static public function mdlSalidaUsuario($tabla,$datosSalida){

		$stmt = Conexion::conectar()->prepare("UPDATE  $tabla SET horaSalida = :horaSalida WHERE nroSesion = :nroSesion and Usuario_identificador = :Usuario_identificador");
		$stmt->bindParam(":horaSalida",$datosSalida["horaSalida"] , PDO::PARAM_STR);
		$stmt->bindParam(":nroSesion",$datosSalida["nroSesion"] , PDO::PARAM_STR);
		$stmt->bindParam(":Usuario_identificador",$datosSalida["Usuario_identificador"] , PDO::PARAM_STR);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}
	}

}
