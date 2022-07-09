<?php

require_once "conexion.php";

Class ModeloSubproceso{


     public static function mdlMostrarSubproceso(string $tabla, string $item, ?Type $valor){

        if(is_null($valor)){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();

		}else{
			$stmt = Conexion::conectar()->prepare("SELECT  * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();

		}

    }
}