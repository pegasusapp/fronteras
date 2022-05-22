<?php

require_once "conexion.php";

class ModeloLogin_attempts{

	/*=============================================
	MOSTRAR LOGIN_ATTEMPTS
	=============================================*/

	static public function mdlMostrarLoginAttemps($tabla, $item, $valor,$item1,$condicion1,$valor1){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}

/*else if ($item1 != null) {
      if($condicion1=="mayor"){$condicion1=">";}
      $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND $item1.$condicion1.$valor1");

      $stmt -> bindParam(":".$item1, $valor, PDO::PARAM_STR);

      $stmt -> execute();

      return $stmt -> fetch();
  }*/
    else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}


		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	MOSTRAR LOGIN_ATTEMPTS FECHA
	=============================================*/

	static public function mdlMostrarLoginAttempsFecha($Usuario_identificador,$tiempo){

		if($Usuario_identificador != null){

			$stmt = Conexion::conectar()->prepare("SELECT count(*) as total FROM login_attempts WHERE Usuario_identificador = '$Usuario_identificador' AND fecha > '$tiempo'");

			//$stmt -> bindParam(":".$Usuario_identificador, $valor, PDO::PARAM_STR);

			$stmt -> execute();
			$count = $stmt->fetchColumn();
			return $count;

		}



		$stmt -> close();

		$stmt = null;

	}


	/*=============================================
	REGISTRO DE LOGIN_ATTEMPS
	=============================================*/

	static public function mdlIngresarLoginAttemps($tabla, $datos_login_fallido)
	{
      try {
			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(fecha, Usuario_identificador) VALUES (:fecha, :Usuario_identificador)");
			$stmt->bindParam(":fecha", $datos_login_fallido["fecha"], PDO::PARAM_STR);
	    	$stmt->bindParam(":Usuario_identificador", $datos_login_fallido["Usuario_identificador"], PDO::PARAM_STR);
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
		catch (PDOException $e) {
			//error
			return  "Your fail message: " . $e->getMessage();
		}
		

	}


}
