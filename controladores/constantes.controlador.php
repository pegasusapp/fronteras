<?php

class Constantes{

	const NOMBRE_EMPRESA="ITALENER";
	const FILE_SIZE = "5000000"; // 5 Megas
	const FROM_NAME_EMAIL = "Italener";
	const EMAIL_COMPANY = "notificaciones.italener@gmail.com";
	const MSG_BLOQUEO = '<br><div class="alert alert-danger">Usted ha sido bloqueado</div>';
	const MSG_BLOQUEO_TEMP = '<br><div class="alert alert-warning">Demasiados intentos fallidos. Inténtelo de nuevo en 2 horas.</div>';
	const MSG_INACTIVO = '<br><div class="alert alert-danger">Su usuario se encuentra inactivo</div>';
	const MSG_ERROR_INGRESO = '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';
	const DIR_IMG_USR = "vistas/img/usuarios/";
	const DIR_IMG_USR_DEFAULT = "vistas/img/usuarios/default/anonymous.png";
	const NAME_WS = "webserviceConsumosActual";
	const DIRIN_WS = "telmetergy.webservices";
	const SIGLA_ACTIVA = "kWhD";
	const SIGLA_REACTIVA = "kVarhD";
	const SIGLA_CAPACITIVA = "kVarhR";
	const SIGLA_SING_ACTIVA = "A";
	const SIGLA_SING_CAPACITIVA = "C";
	const SIGLA_SING_PENALIZADA = "P";
	const SIGLA_EXPORTADA = "kWhR";
	const SIGLA_MEDIDOR_PROD  = "P";
	const URL_WS = "https://medicion.telmetergy.com.co/xmlrpc/2/object";
	const URL_IMG_REPORT = "https://fronteras.energiaitalener.com/files/imgFrt/";
	const URL_IMG_DEFAULT = "https://fronteras.energiaitalener.com/files/imgDefault/no-data-found.png";

	// Secretos externalizados (leídos de config.local.php si existe)
	private static $secrets = null;

	private static function getSecret($key, $default) {
		if (self::$secrets === null) {
			$configFile = dirname(__DIR__) . '/config.local.php';
			self::$secrets = file_exists($configFile) ? require $configFile : array();
		}
		return isset(self::$secrets[$key]) ? self::$secrets[$key] : $default;
	}

	public static function PASS_EMAIL_COMPANY() { return self::getSecret('PASS_EMAIL_COMPANY', ''); }
	public static function USER_WS()             { return self::getSecret('USER_WS', ''); }
	public static function PASSW_WS()            { return self::getSecret('PASSW_WS', ''); }
}