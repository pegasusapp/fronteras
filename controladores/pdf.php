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
$dompdf = new Dompdf();
$item ="";
$valor="";
$arrayFrontera = ControladorFronteras::ctrMostrarFronteras($item,$valor);
echo "--->".dirname(__FILE__);
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
  $ruta = dirname(__FILE__);
  $content='<table id="tabla_central" align="center" style="width:70%; font-size: 13px;" border="1" cellspacing="0" cellpadding="2" bordercolor="666633">
    <tr>
      <td width="15%" height="50"><img align="center" src="'.$ruta.'/template/images/logo-blanco-bloque.png"  height="100" width="150"></td>
      <td width="33%" height="50" colspan="2" style="text-align: center;"><strong>ORDEN DE SERVICIOS - BOLIVAR</strong></td>
       <td width="15%" height="50" align="center"><img  src="'.$ruta.'/sga/img/arlbolivar.png"  height="100" width="100"></td>
      <td width="15%" height="50" ><div id="span1" class="t r"><label style="text-align: center;"><strong>FP-S 001</strong></label></div><div id="span2" class="t r">Versi&oacute;n:01</div></td>
    </tr>
    <tr>
      <td>ORDEN #</td>
      <td></td>
      <td>FECHA ORDEN</td>
      <td colspan="2">asd</td>
    </tr>
    <tr>
      <td>CONSULTOR:</td>
      <td colspan="4">asd</td>
    </tr>
    <tr><td colspan="5">
     De acuerdo a las condiciones pactadas previamente con el Cliente y con el consultor asignado se relaciona la informaci&oacute;n requerida para la prestaci&oacute;n del servicio
    </td>
    </tr>
    <tr><td colspan="5" align="center" bgcolor="#bcc1d1"><strong>DETALLE DE LA EMPRESA A ATENDER</strong></td>							
    </tr>
    <tr>
      <td colspan="2">NOMBRE DE LA EMPRESA:</td>
      <td colspan="3">ad</td>
    </tr>
    <tr>		
      <td colspan="2">ACTIVIDAD DE LA EMPRESA:</td>
      <td colspan="3">asd</td>
    </tr>
    <tr>		
      <td colspan="2">NIT:</td>
      <td colspan="3">asd</td>
    </tr>
    <tr>		
      <td colspan="2">CIUDAD:</td>
      <td colspan="3">asd</td>
    </tr>
    <tr>
      <td colspan="2">DIRECCION:</td>
      <td colspan="3">sad</td>
    </tr>
    <tr>	
      <td colspan="2">CONTACTO:</td>
      <td colspan="3">ads</td>
    </tr>
    <tr>	
      <td colspan="2">TELEFONOS:</td>
      <td colspan="3">asd</td>
    </tr>
    <tr><td colspan="5" align="center" bgcolor="#bcc1d1"><strong>DETALLE DEL SERVICIO A PRESTAR</strong></td>							
    </tr>
    <tr>
      <td colspan="2">EMPRESA AFILIADA A:</td>
      <td colspan="3">asd</td>
    </tr>  
    <tr>		
    <td>POLIZA:</td>
    <td>ads</td>
    <td>ACT PROGRAMA</td>
    <td colspan="2">asd</td>
    </tr>
    <tr>	
      <td>CRONOGRAMA</td>
      <td>asd</td>
     <td>SECUENCIA</td>
      <td colspan="2">asd</td>
    </tr>
    <tr>	
     <td colspan="2">ASESOR DNPR:</td>
     <td colspan="3">as</td>
     </tr>
     <tr>
      <td>OBSERVACIONES:</td>
      <td colspan="4" bgcolor="#00FF00">as</td>
     </tr>
     <tr>
       <td colspan="5" align="center" bgcolor="#bcc1d1"><strong>RELACION DE HORAS Y FECHAS</strong>as</td>							
    </tr>
    <tr>
    <td align="center">NRO. HORAS</td><td align="center">TIPO DE ACTIVIDAD</td><td align="center">ACTIVIDAD A REALIZAR</td><td align="center">FECHA EJECUCION PROGRAMADA EN SIPAB</td><td align="center">VLR UNITARIO</td>
    </tr>
    <tr>
    <td>as</td>
    <td>as</td>
    <td>sa</td>
    <td>as</td>
    <td>as</td>
    </tr>
    <tr>
    <td colspan="4"><label style="margin-left:430;">TOTAL</label></td>
    <td>as</td>
    </tr>
    </table>';
$dompdf->set_option('enable_html5_parser', TRUE);
$dompdf->loadHtml($content);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
//$dompdf->stream();
//print the pdf file to the screen for saving
//save the pdf file on the server
file_put_contents("invoice-" . $valor["fronteraCliente"] . ".pdf",  $dompdf->output());
}
?>