<?php

class Conexion{

	

	static public function conectar()
		{
	    $link = null;
		 try {
				$link = new PDO("mysql:host=localhost;dbname=energia6_fronteras","energia6_fronteras","_Frt*23092020 ?.",[PDO::MYSQL_ATTR_INIT_COMMAND => "SET lc_time_names='es_CO'"]);
				$link->exec("set names 'utf8';");
				$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
			}
			catch(PDOException $e)
			    {
			    echo "Connection failed: " . $e->getMessage();
				}
			return $link;	
		 }
	
	static public function cerrarConexion()
		 {
			 $link = null;
		 }

	

	}	 
