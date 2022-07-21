<?php
require_once 'dompdf/autoload.inc.php';
require dirname(__FILE__)."/../modelos/fronteras.modelo.php";
require dirname(__FILE__)."/../modelos/factorm.modelo.php";
require dirname(__FILE__)."/../modelos/desviacion.modelo.php";
require "utilidades.controlador.php";
require "constantes.controlador.php";
require "fronteras.controlador.php";
require "factorm.controlador.php";
require "desviacion.controlador.php";
use Dompdf\Dompdf;

$item ="";
$valor="";
$arrayFrontera = ControladorFronteras::ctrMostrarFronteras($item,$valor);
foreach($arrayFrontera as $valor){
    $arrayAvg = array();
    $arrayLastDay = array(); 
    $arrayAvg = ControladorFronteras::ctrMostrarAvgEnergiasFrontera($valor["fronteraCliente"],Constantes::SIGLA_SING_ACTIVA,1);
    //Note mysql result: 1=Sunday, 2=Monday, 3=Tuesday, 4=Wednesday, 5=Thursday, 6=Friday, 7=Saturday.
    //Note php result: 0=Sunday, 1=Monday, 2=Tuesday, 3=Wednesday, 4=Thursday, 5=Friday, 6=Saturday.
    //$fecha = explode("-",ControladorUtilidades::anyoMesDia(1));	
    $dayToday = ControladorUtilidades::getDayToMysql(ControladorUtilidades::getNumberday(ControladorUtilidades::anyoMesDia(1)));
    $total_dia_avg=0;
    foreach($arrayAvg as $data)
    {
      if($dayToday == $data["dia"]){
        $total_dia_avg = $data["total_dia"];
      }
    }
    $arrayLastDay = ControladorFronteras::ctrMostrarEnergiasFronteraDia($valor["fronteraCliente"],1);
    $total_dia_last=0;
    foreach($arrayLastDay as $data)
    {
      if($data["tipoEnergia"] === "A"){
        $total_dia_last = $data["total_dia"];
      }
    }
    $vlr_minimo = 0;
    $vlr_maximo = 0;
    $arrayDesviacion = ControladorDesviacion::ctrMostrarDesviacion($item,$valor);
    foreach($arrayDesviacion as $data){
        $vlr_minimo = $data["vlrMinimo"];
        $vlr_maximo = $data["vlrMaximo"];
    }
    //operation to calculate deviation
    $tope_max = $total_dia_avg*(1+$vlr_maximo);
    $tope_min = $total_dia_avg*(1+$vlr_minimo);
    $desviado="SI";
    if($total_dia_last >= $tope_min && $total_dia_last <= $tope_max){
        $desviado="NO";
    }
    $data = array("frontera" => $valor["fronteraCliente"],"consumoPromedio" =>$total_dia_avg,"consumoAnterior"=>$total_dia_last ,"desviado" => $desviado, "productPrice" => "20", "deliveryDate" => "2150");
    $ruta=$_SERVER["DOCUMENT_ROOT"];
    $dompdf = new Dompdf();
  $content='<table id="tabla_central" align="center" style="width:70%; font-size: 13px;" border="1" cellspacing="0" cellpadding="2" bordercolor="666633"><tr><td width="15%" height="50"><img align="center" src="logo-blanco-bloque.png"   height="100" width="150"></td><td width="33%" height="50" colspan="2" style="text-align: center;"><strong>ORDEN DE SERVICIOS - BOLIVAR</strong></td><td width="15%" height="50" align="center"><img  src="'.$ruta.'/sga/img/arlbolivar.png"  height="100" width="100"></td><td width="15%" height="50" ><div id="span1" class="t r"><label style="text-align: center;"><strong>FP-S 001</strong></label></div><div id="span2" class="t r">Versi&oacute;n:01</div></td></tr><tr><td>ORDEN #</td><td></td><td>FECHA ORDEN</td><td colspan="2">asd</td></tr></table>';
  $dompdf->set_option('enable_html5_parser', TRUE);
  $dompdf->loadHtml($content);
  $dompdf->setPaper('A4', 'landscape');
  $dompdf->render();
file_put_contents("invoice-" . $valor["fronteraCliente"] . ".pdf",  $dompdf->output());
}
?>