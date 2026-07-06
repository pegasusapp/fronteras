<?php

class Conexion{

	

	static public function conectar()
		{
		$configFile = dirname(__DIR__) . '/config.local.php';
		$conf = file_exists($configFile) ? require $configFile : array();
		$host = isset($conf['DB_HOST']) ? $conf['DB_HOST'] : 'localhost';
		$db   = isset($conf['DB_NAME']) ? $conf['DB_NAME'] : 'energia6_fronteras';
		$user = isset($conf['DB_USER']) ? $conf['DB_USER'] : 'energia6_fronteras';
		$pass = isset($conf['DB_PASS']) ? $conf['DB_PASS'] : '';
		$dsn  = "mysql:host={$host};dbname={$db}";
	    $link = null;
		 try {
				$link = new PDO($dsn, $user, $pass, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET lc_time_names='es_CO'"]);
				$link->exec("set names 'utf8';");
				$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
			}
			catch(PDOException $e)
			    {
			    error_log("Connection failed: ".$e->getMessage());
				}
			return $link;	
		 }
	
	static public function cerrarConexion()
		 {
			 $link = null;
		 }

	

	}	 