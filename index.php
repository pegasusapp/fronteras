<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/menu.controlador.php";
require_once "controladores/crearPerfil.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/fronteras.controlador.php";
require_once "controladores/clienteFrontera.controlador.php";
require_once "controladores/constantes.controlador.php";
require_once "controladores/validaciones.controlador.php";
require_once "controladores/utilidades.controlador.php";
require_once "controladores/factura.controlador.php";
require_once "controladores/logLectura.controlador.php";
require_once "controladores/desviacion.controlador.php";
require_once "controladores/logLecturaWS.controlador.php";
require_once "controladores/factorm.controlador.php";
require_once "controladores/ctrfactorm.controlador.php";


require_once "modelos/usuarios.modelo.php";
require_once "modelos/menu.modelo.php";
require_once "modelos/login_attempts.modelo.php";
require_once "modelos/crearPerfil.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/fronteras.modelo.php";
require_once "modelos/clienteFrontera.modelo.php";
require_once "modelos/factura.modelo.php";
require_once "modelos/logLectura.modelo.php";
require_once "modelos/desviacion.modelo.php";
require_once "modelos/logLecturaWS.modelo.php";
require_once "modelos/subproceso.modelo.php";
require_once "modelos/factorm.modelo.php";
require_once "modelos/ctrfactorm.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();

?>
