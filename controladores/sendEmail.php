<?php
ini_set('max_execution_time', '300');
require dirname(__FILE__)."/../modelos/fronteras.modelo.php";
require "utilidades.controlador.php";
require "constantes.controlador.php";
require "fronteras.controlador.php";
function executeScriptToSendPDF(){
$item ="";
$valor="";
$arrayFrontera = ControladorFronteras::ctrMostrarFronteras($item,$valor);
foreach($arrayFrontera as $valor){
    $dataFile = [];
    $arrayCliente = [];
    $dataFile = array("nameFile" =>"file-".$valor["fronteraCliente"],"extension"=>"pdf","ubication"=>dirname(__FILE__)."/../files/pdf/");
    $arrayCliente = ControladorClientesFrontera::ctrMostrarClientesFrontera("nitCliente", $valor["clienteFrontera_nitCliente"]);
    $mailDestiny = "oscar.2001601@gmail.com";
    echo ControladorUtilidades::sendMail("Reporte diario de la frontera ".$valor["fronteraCliente"],$mailDestiny,"Adjunto a este correo encontrará el reporte del día anterior de la frontera ".$valor["clienteFrontera_nitCliente"],$dataFile);
}
}
?>