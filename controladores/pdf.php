<?php
ini_set('max_execution_time', '300');
require_once 'dompdf/autoload.inc.php';
require dirname(__FILE__)."/../modelos/fronteras.modelo.php";
require dirname(__FILE__)."/../modelos/factorm.modelo.php";
require dirname(__FILE__)."/../modelos/desviacion.modelo.php";
require dirname(__FILE__)."/../modelos/ctrfactorm.modelo.php";
require "utilidades.controlador.php";
require "constantes.controlador.php";
require "fronteras.controlador.php";
require "factorm.controlador.php";
require "desviacion.controlador.php";
require "ctrfactorm.controlador.php";
use Dompdf\Dompdf;
use Dompdf\Options;
function executeScriptToCreatePDF(){
$item ="";
$valor="";
$arrayFrontera = ControladorFronteras::ctrMostrarFronteras($item,$valor);
foreach($arrayFrontera as $valor){
    $datosFrontera = [];
    $datosFrontera = array("frt"=>$valor["fronteraCliente"],"nombreFrt"=> $valor["descripcionFrontera"]);
    $arrayAvg = [];
    $arrayAvg = ControladorFronteras::ctrMostrarAvgEnergiasFrontera($valor["fronteraCliente"],Constantes::SIGLA_SING_ACTIVA,1);
    $total_dia_avg = desviacionFronteras($arrayAvg);
    $total_dia_last = totalAnteriorDiaFrontera($valor["fronteraCliente"]);
    $desviado = resultadoDesviado($total_dia_avg,$total_dia_last);
    $htmlFactorM= resultadoFactorM($valor["fronteraCliente"]);
    $totalActivaMonth = 0;
    $totalReactivaMonth = 0;
    $totalCapacitivaMonth = 0;
    $totalPerdidasMonth = 0;
    $arrayTotalesByEnergyMonth = ControladorFronteras::ctrMostrarEnergiaFronteraMesEnergia($valor["fronteraCliente"]);
    foreach($arrayTotalesByEnergyMonth as $vlr){
        if($vlr["tipoEnergia"] === "A"){
            $totalActivaMonth = $vlr["total_mes"];
          }
        elseif($vlr["tipoEnergia"] === "R"){
            $totalReactivaMonth = $vlr["total_mes"];
          }
        elseif($vlr["tipoEnergia"] === "C"){
            $totalCapacitivaMonth = $vlr["total_mes"];
          }
        elseif($vlr["tipoEnergia"] === "P"){
            $totalPerdidasMonth = $vlr["total_mes"];
          }
    }
      $content = plantillaPdf($datosFrontera,$total_dia_avg,$total_dia_last,$desviado,$htmlFactorM,$totalActivaMonth,$totalReactivaMonth,$totalCapacitivaMonth,$totalPerdidasMonth);
      createPDF($content,$valor["fronteraCliente"]);
}

}

function createPDF($content,$frontera){
  $dompdf = new Dompdf();
  $options = new Options();
  $dompdf->loadHtml($content);
  $options->set('enable_remote', TRUE);
  $options->set('enable_css_float', TRUE);
  $options->set('enable_html5_parser', FALSE);
  $dompdf->setOptions($options);
  $dompdf->setPaper('A4', 'landscape');
  $dompdf->render();
  $resultado = file_put_contents(dirname(__FILE__)."/../files/pdf/"."file-" . $frontera . ".pdf",  $dompdf->output());
  echo $resultado."<br>";
}

function resultadoFactorM($frontera):string{
  $arrayDataFactorM = ControladorCtrFactorM::ctrMostrarctrFactorMLastThreMonths($frontera);
  $htmlFactorM="";
  foreach($arrayDataFactorM as $vlr){
            $bgcolor="";

            if($vlr["dias"] >5 && $vlr["dias"] < 10)
            {
                $bgcolor="#ffd433";
            }
            elseif($vlr["dias"] >=10){
                $bgcolor="#ff4c33";
            }
            $htmlFactorM .= '<tr>
                                <td align="center">'.$vlr["anyo"].'-'.$vlr["mes"].'</td>
                                <td align="center" bgcolor="'.$bgcolor.'">'.$vlr["factor"].'</td>
                                <td align="center" bgcolor="'.$bgcolor.'">'.$vlr["dias"].'</td>
                                <td align="center">'.ControladorUtilidades::tipoEnergia($vlr["tipoEnergia"]).'</td>                            </tr>';
        }
    return $htmlFactorM;
}

function desviacionFronteras($arrayAvg):float{
  $dayToday = ControladorUtilidades::getDayToMysql(ControladorUtilidades::getNumberday(ControladorUtilidades::anyoMesDia(1)));
  $total_dia_avg = 0;
  foreach($arrayAvg as $data)
  {
    if($dayToday == $data["dia"]){
      $total_dia_avg = $data["total_dia"];
    }
  }

  return $total_dia_avg;


}

function totalAnteriorDiaFrontera($frontera):float{
  $arrayLastDay = [];
  $arrayLastDay = ControladorFronteras::ctrMostrarEnergiasFronteraDiaxEnergia($frontera,1,Constantes::SIGLA_SING_ACTIVA);
  $total_dia_last=0;
  foreach($arrayLastDay as $data)
  {
      $total_dia_last = $data["total_dia"];
  }
  return $total_dia_last;
}

function resultadoDesviado($total_dia_avg,$total_dia_last):string{
        $vlr_minimo = 0;
        $vlr_maximo = 0;
        $arrayDesviacion = ControladorDesviacion::ctrMostrarDesviacion(null,null);
        foreach($arrayDesviacion as $data){
            $vlr_minimo = $data["vlrMinimo"];
            $vlr_maximo = $data["vlrMaximo"];
        }
        //operation to calculate deviation
        echo "-->".$total_dia_avg."-".$vlr_maximo."<br>";;
        $tope_max = $total_dia_avg*(1+$vlr_maximo);
        $tope_min = $total_dia_avg*(1+$vlr_minimo);
        $desviado="SI";
        if($total_dia_last >= $tope_min && $total_dia_last <= $tope_max){
            $desviado="NO";
        }
        return $desviado;
}
function plantillaPdf($datosFrontera,$total_dia_avg,$total_dia_last,$desviado,$htmlFactorM,$totalActivaMonth,$totalReactivaMonth,$totalCapacitivaMonth,$totalPerdidasMonth):string{

  $srcImgConsumo = @getimagesize(Constantes::URL_IMG_REPORT.$datosFrontera['frt']."_consumo.png") ? Constantes::URL_IMG_REPORT.$datosFrontera['frt']."_consumo.png": Constantes::URL_IMG_DEFAULT;
  $srcImgDesviacion = @getimagesize(Constantes::URL_IMG_REPORT.$datosFrontera['frt']."_desviacion.png") ? Constantes::URL_IMG_REPORT.$datosFrontera['frt']."_desviacion.png": Constantes::URL_IMG_DEFAULT;
  $srcImgCapacitiva = @getimagesize(Constantes::URL_IMG_REPORT.$datosFrontera['frt']."_capacitiva.png") ? Constantes::URL_IMG_REPORT.$datosFrontera['frt']."_capacitiva.png": Constantes::URL_IMG_DEFAULT;
  $srcImgPerdidas = @getimagesize(Constantes::URL_IMG_REPORT.$datosFrontera['frt']."_perdidas.png") ? Constantes::URL_IMG_REPORT.$datosFrontera['frt']."_perdidas.png": Constantes::URL_IMG_DEFAULT;
  return '<style>
  #customers
    {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse; width: 100%;
    }
  #customers td, #customers th
    {
      border: 1px solid #ddd; padding: 4px;
    }
  #customers tr:nth-child(even)
    {
      background-color: #f2f2f2;
    }
  #customers tr:hover
    {
      background-color: #ddd;
    }
  #customers th
  {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #04AA6D;
    color: white;
  }
  .u-repeater { flex-grow: 1; flex-shrink: 1; flex-basis: auto; } 
  .u-repeater { display: grid; grid-template-columns: repeat(4, 25%); } 
  .u-align-center { text-align: center; } 
  .u-section-5 
  .u-text-1 { font-weight: 700; font-size: 3rem; margin: 20px 0 0; } 
  .u-text-palette-2-base, 
  li.active > a.u-button-style.u-text-palette-2-base, 
  li.active > a.u-button-style.u-text-palette-2-base[class*="u-border-"], 
  a.u-button-style.u-text-palette-2-base, 
  a.u-button-style.u-text-palette-2-base[class*="u-border-"] { color: #db545a !important; } 
  .u-section-5 
  .u-icon-1 { width: 64px; background-image: none; margin: 0 auto; } 
  .u-icon { display: block; line-height: 0; border-width: 0px; } 
  #block_container { text-align:center; } 
  #bloc1, #bloc2 { display:inline; } 
  .gfg { width:auto; text-align:center; padding:20px; } 
  .imgFrtConsumo { width:70%; height:auto; } 
  .imgFrtDesviacion { width:70%; height:auto; } 
  .imgFrt { width:80%; height:auto; } 
  </style>
  <table id="customers" align="center" style="width:100%; font-size: 15px;" border="1" cellspacing="0" cellpadding="2" bordercolor="666633">
  <tr>
    <td width="15%" height="50">
      <img align="center" src="https://fronteras.energiaitalener.com/controladores/template/images/logo-blanco-bloque.png"  >
    </td>
    <td width="65%" height="50" colspan="6" style="text-align: center;">
      <strong>REPORTE DIARIO RELACIONADO CON LA FRONTERA - '.$datosFrontera["nombreFrt"].'</strong>
    </td>
    <td width="20%" height="50" >
      <div id="span1" class="tr">
        <label style="text-align: center;"><strong>Fecha reporte: '.ControladorUtilidades::anyoMesDia(0).'</strong></label>
      </div>
      <div id="span1" class="tr">
        <label style="text-align: center;"><strong>Fecha analisis: '.ControladorUtilidades::anyoMesDia(1).'</strong></label>
      </div>
    </td>
  </tr>
  <tr>
    <td width="50%" colspan="4" align="center" bgcolor="#bcc1d1"><strong>COMPARACION DE CONSUMOS</strong></td>
    <td width="50%" colspan="4" align="center" bgcolor="#bcc1d1"><strong>DESVIACION SIGNIFICATIVA</strong></td>
  </tr>
  <tr>
    <td width="50%" colspan="4">Consumo mes anterior vs consumo mes actual</td>
    <td width="50%" colspan="4">Consumo actual del día '.round($total_dia_last,2).' KWh vs consumo promedio '.round($total_dia_avg,2).' KWh. <strong>'.$desviado.'</strong> presenta desviación </td>
  </tr>
  <tr>
    <td width="50%" colspan="4" align="center"><img class="imgFrtConsumo" src="'.$srcImgConsumo.'"></td>
    <td width="50%" colspan="4" align="center"><img class="imgFrtDesviacion" src="'.$srcImgDesviacion.'"></td>
  </tr>
  <tr>
    <td width="50%" colspan="4" align="center" bgcolor="#bcc1d1"><strong>FACTOR M (APLICA SUPERIOR 10 DÍAS)</strong></td>
    <td width="50%" colspan="4" align="center" bgcolor="#bcc1d1"><strong>CONSUMO DE ENERGIAS EN EL MES</strong></td>
  </tr>
    <tr>
      <td width="50%" colspan="4">
        <table align="center" style="width:100%; font-size: 15px;" border="1" cellspacing="0" cellpadding="2" bordercolor="666633">
            <tr>
              <td align="center"><strong>AÑO-MES</strong></td>
              <td align="center"><strong>FACTOR</strong></td>
              <td align="center"><strong>DIAS</strong></td>
              <td align="center"><strong>TIPO ENERGIA PENALIZADA</strong></td>
            </tr>
            '.$htmlFactorM.'
        </table>
    </td>
    <td width="50%" colspan="4">
        <table align="center"  border="1" bordercolor="666633">
                    <tr>
                      <td align="center"><h3 class="u-custom-font u-font-montserrat u-text u-text-palette-2-base u-text-1" >'.number_format(round($totalActivaMonth,2), 2, '.', ',').' KWh</h3></td>
                      <td align="center"><h3 class="u-custom-font u-font-montserrat u-text u-text-palette-2-base u-text-3" >'.number_format(round($totalReactivaMonth,2), 2, '.', ',').' KVArh</h3></td>
                      <td align="center"><h3 class="u-custom-font u-font-montserrat u-text u-text-palette-2-base u-text-5" >'.number_format(round($totalCapacitivaMonth,2), 2, '.', ',').' KVArhR</h3></td>
                      <td align="center"><h3 class="u-custom-font u-font-montserrat u-text u-text-palette-2-base u-text-7" >'.number_format(round($totalPerdidasMonth,2), 2, '.', ',').' KVArhD</h3></td>
                    </tr>
                    <tr>
                      <td align="center"><h4 class="u-custom-font u-font-montserrat u-text u-text-2">Activa</h4></td>
                      <td align="center"><h4 class="u-custom-font u-font-montserrat u-text u-text-4">Reactiva</h4></td>
                      <td align="center"><h4 class="u-custom-font u-font-montserrat u-text u-text-6">Penal. Capacitiva</h4></td>
                      <td align="center"><h4 class="u-custom-font u-font-montserrat u-text u-text-8">Penal. Inductiva</h4></td>
                    </tr>
        </table>
    </td>
    </tr>
    <tr>
    <td colspan="8" style="padding-bottom: 10px;"></td>
    </tr>
    <tr>
    <td width="50%" colspan="4" align="center" bgcolor="#bcc1d1"><strong>COMPORTAMIENTO DE ENERGIA CAPACITIVA </strong></td>
    <td width="50%" colspan="4" align="center" bgcolor="#bcc1d1"><strong>COMPORTAMIENTO DE ENERGIA INDUCTIVA </strong></td>
    </tr>
    <tr>
    <td width="50%" colspan="4">Comportamiento generación energia capacitiva. </td>
    <td width="50%" colspan="4">Comportamiento generación de energia inductiva. </td>
    </tr>
    <tr>
    <td width="50%" colspan="4" align="center"><img class="imgFrt" src="'.$srcImgCapacitiva.'"></td>
    <td width="50%" colspan="4" align="center"><img class="imgFrt" src="'.$srcImgPerdidas.'"></td>
    </tr>
  </table>';
}
executeScriptToCreatePDF();
?>