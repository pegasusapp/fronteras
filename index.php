<?php

require_once "controladores/plantilla.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/menu.controlador.php";
require_once "controladores/crearPerfil.controlador.php";
require_once "controladores/estado_solicitud.controlador.php";
require_once "controladores/areas.controlador.php";
require_once "controladores/fuentes.controlador.php";
require_once "controladores/totales.controlador.php";
require_once "controladores/perfiles.controlador.php";
require_once "controladores/equipos.controlador.php";
require_once "controladores/potencia.controlador.php";
require_once "controladores/produccion.controlador.php";
require_once "controladores/alterno.controlador.php";
require_once "controladores/proyectos.controlador.php";
require_once "controladores/solicitud.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/gproyecto.controlador.php";
require_once "controladores/fronteras.controlador.php";
require_once "controladores/clienteFrontera.controlador.php";
require_once "controladores/constantes.controlador.php";
require_once "controladores/validaciones.controlador.php";
require_once "controladores/utilidades.controlador.php";

require_once "modelos/usuarios.modelo.php";
require_once "modelos/menu.modelo.php";
require_once "modelos/alterno.modelo.php";
require_once "modelos/login_attempts.modelo.php";
require_once "modelos/itemPlantillaTrabajo.modelo.php";
require_once "modelos/solicitud.modelo.php";
require_once "modelos/proyectos.modelo.php";
require_once "modelos/areas.modelo.php";
require_once "modelos/crearPerfil.modelo.php";
require_once "modelos/estado_solicitud.modelo.php";
require_once "modelos/fuentes.modelo.php";
require_once "modelos/totales.modelo.php";
require_once "modelos/perfiles.modelo.php";
require_once "modelos/equipos.modelo.php";
require_once "modelos/potencia.modelo.php";
require_once "modelos/produccion.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/gproyecto.modelo.php";
require_once "modelos/pais.modelo.php";
require_once "modelos/fronteras.modelo.php";
require_once "modelos/clienteFrontera.modelo.php";


$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();

?>
