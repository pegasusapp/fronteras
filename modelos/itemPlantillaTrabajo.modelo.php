<?php

require_once "conexion.php";

class ModeloItemPlantillaTrabajo{


	/*=============================================
	CREAR ITEM
	=============================================*/
	/*
	static public function lastInsertId()
	 {
            return Conexion::conectar()->lastInsertId();
	 } 
	 */

	static public function mdlIngresarItemPlantillaTrabajo($tabla,$datos,$datos2){

		// set the PDO error mode to exception
		  $fechaHoy = date("Y-m-d H:i:s");
		  $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (descripcionItem,PlantillaTrabajo_idPlantillaTrabajo,opciones_valor_idopciones_valor,fechaCreacion,fechaActualizacion) VALUES (:descripcionItem,:PlantillaTrabajo_idPlantillaTrabajo,:opciones_valor_idopciones_valor,:fechaCreacion,:fechaActualizacion)");
			  $stmt->bindParam(":descripcionItem",$datos["descripcionItem"], PDO::PARAM_STR);
		      $stmt->bindParam(":PlantillaTrabajo_idPlantillaTrabajo",$datos["PlantillaTrabajo_idPlantillaTrabajo"], PDO::PARAM_INT);
		      $stmt->bindParam(":opciones_valor_idopciones_valor",$datos2["opciones_valor_idopciones_valor"], PDO::PARAM_INT);
		      $stmt->bindParam(":fechaCreacion",$fechaHoy, PDO::PARAM_STR);
		      $stmt->bindParam(":fechaActualizacion",$fechaHoy, PDO::PARAM_STR);

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
	MOSTRAR ITEMS
	=============================================*/

	static public function mdlMostrarItemPlantillaTrabajo( $item, $valor)
		{

	

			$stmt = Conexion::conectar()->prepare("Select * from (Select   it.idItemPlantilla ,it.descripcionItem,pt.nombrePlantilla,GROUP_CONCAT(tr.tipoRespuesta) as respuestas from  PlantillaTrabajo pt  
	         left join  ItemPlantilla it on pt.idPlantillaTrabajo = it.PlantillaTrabajo_idPlantillaTrabajo  
	         left join TipoRespuesta_has_ItemPlantilla thi on it.idItemPlantilla = thi.ItemPlantilla_idItemPlantilla
	         left join TipoRespuesta tr on thi.TipoRespuesta_idTipoRespuesta = tr.idTipoRespuesta WHERE $item = $valor group by idItemPlantilla) T1 
	         where T1.idItemPlantilla IS NOT NULL");

				//$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();
	 		return $stmt -> fetchAll(); 
			$stmt -> close();
			$stmt = null;

		}
		/*=============================================
	MOSTRAR UN ITEM
	=============================================*/

	static public function mdlMostrarUnItemPlantillaTrabajo( $item, $valor)
		{

	 

			$stmt = Conexion::conectar()->prepare("Select it.idItemPlantilla ,it.descripcionItem,GROUP_CONCAT(thi.TipoRespuesta_idTipoRespuesta) as respuestas from  ItemPlantilla it left join TipoRespuesta_has_ItemPlantilla thi on it.idItemPlantilla = thi.ItemPlantilla_idItemPlantilla
	          WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();
			$stmt -> close();
			$stmt = null; 

		}


	/*=============================================
	EDITAR ITEM
	=============================================*/

	static public function mdlEditarItemPlantillaTrabajo($tabla, $datos)
		{

			
			// actualizamos la descripción
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET descripcionItem = :descripcionItem WHERE idItemPlantilla = :idItemPlantilla");

			$stmt->bindParam(":idItemPlantilla", $datos["idItemPlantilla"], PDO::PARAM_INT);
			$stmt->bindParam(":descripcionItem", $datos["descripcionItem"], PDO::PARAM_STR);
			//$stmt->bindParam(":TipoRespuesta_idTipoRespuesta", $datos["TipoRespuesta_idTipoRespuesta"], PDO::PARAM_INT);

			if($stmt->execute())
				{

					//Borramos las opciones que existe de respuesta para ingresar las nuevas
					$stmt = Conexion::conectar()->prepare("DELETE FROM TipoRespuesta_has_ItemPlantilla WHERE ItemPlantilla_IdItemPlantilla = :ItemPlantilla_IdItemPlantilla");	
					$stmt -> bindParam(":ItemPlantilla_IdItemPlantilla", $datos["idItemPlantilla"], PDO::PARAM_INT);
					if($stmt -> execute())
						{
							 $fechaHoy = date("Y-m-d H:i:s");
						     $valorUno=1;
						     $tr=$datos["TipoRespuesta_idTipoRespuesta"];
						     $i=0;
							
						   foreach ($tr as $valores)
							       {
							      	
								  $stmt2 = Conexion::conectar()->prepare("INSERT INTO TipoRespuesta_has_ItemPlantilla(TipoRespuesta_idTipoRespuesta,ItemPlantilla_IdItemPlantilla,fechaRegistro,fechaActualizacion,estado,ultimoUsuario) VALUES (:TipoRespuesta_idTipoRespuesta,:ItemPlantilla_IdItemPlantilla,:fechaRegistro,:fechaActualizacion,:estado,:ultimoUsuario)");
								  $stmt2->bindParam(":TipoRespuesta_idTipoRespuesta",$valores, PDO::PARAM_INT);
							      $stmt2->bindParam(":ItemPlantilla_IdItemPlantilla",$datos["idItemPlantilla"], PDO::PARAM_INT);
							      $stmt2->bindParam(":fechaRegistro",$fechaHoy, PDO::PARAM_STR);
							      $stmt2->bindParam(":fechaActualizacion",$fechaHoy, PDO::PARAM_STR);
							      $stmt2->bindParam(":estado",$valorUno, PDO::PARAM_INT);
							      $stmt2->bindParam(":ultimoUsuario",$_SESSION['niu'], PDO::PARAM_STR);

							      if($stmt2->execute())
							      	{
							        		$i=1;
							        }
							      else
							         {
							         		return "error";

							         }	
							         

							     }
							       return "ok";
							
						}
					else
						{
							return "error";
						}
					$stmt -> close();
					$stmt = null;
					

			    }
			else{

				return "error";
			
			    }

			$stmt->close();
			$stmt = null;

		}


}