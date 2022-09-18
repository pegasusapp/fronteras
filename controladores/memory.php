<?php
require dirname(__FILE__)."/../modelos/fronteras.modelo.php";
require "fronteras.controlador.php";
$arrayFrontera = ControladorFronteras::ctrMostrarFronteras($item,$valor);
var_dump($arrayFrontera);

?>