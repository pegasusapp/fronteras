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
      h1{
        text-align:center;
        font-family: Algerian;
    }
    .flex-container{
        display:flex;
        border:1px solid #808080;
        font-family: Arial, Helvetica, sans-serif;
    }
    .flex-container-f1{
        display:flex;
        border:1px solid #808080;
        font-family: Arial, Helvetica, sans-serif;
    }
    .flex-child{
        flex:1;
        border-right: 1px solid #808080;
        font-size: 20px;
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
    }
    .flex-child:first-child{
        margin-right:0px;
    }
    .imgFrt{
        margin-left: auto;
        margin-right: auto;
        width: 100%;
        display: block;
    }
    .divCabecera{
        margin-top:20px;
        margin-left: 5px;
        margin-right: 5px;
    }
    .container{
        width: 100%;
        margin: auto;
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
    .imgFrt { width:80%; height:auto; }

  </style>

  <div class="container">
      <div class="flex-container">
          <div class="flex-child magenta">
          <img align="center" src="https://fronteras.energiaitalener.com/controladores/template/images/logo-blanco-bloque.png"  >
          </div>
          <div class="flex-child green" >
              <div class="divCabecera" style="text-align:center;font-weight: bold;">
              REPORTE DIARIO RELACIONADO CON LA FRONTERA - '.$datosFrontera["nombreFrt"].'
              </div>
          </div>
          <div class="flex-child orange" >
              <div class="divCabecera" style="text-align:center;font-weight: bold;">
                  <div>Fecha reporte: '.ControladorUtilidades::anyoMesDia(0).'<</div>
                  <div>Fecha analisis: '.ControladorUtilidades::anyoMesDia(1).'</div>
              </div>
          </div>
      </div>
  <div class="flex-container-f1">
      <div class="flex-child titulo" style="text-align:center;background-color: #C5C5C5;font-weight: bold;">
          COMPARACION DE CONSUMOS
      </div>
      <div class="flex-child titulo" style="text-align:center;background-color: #C5C5C5;font-weight: bold;">
          DESVIACION SIGNIFICATIVA
      </div>
  </div>
  <div class="flex-container-f1">
      <div class="flex-child titulo" style="text-align:justify;">
          Consumo mes anterior vs consumo mes actual
      </div>
      <div class="flex-child titulo" style="text-align:justify;">
        Consumo actual del día '.round($total_dia_last,2).' KWh vs consumo promedio '.round($total_dia_avg,2).' KWh. <strong>'.$desviado.'</strong> presenta desviación
      </div>
  </div>
  <div class="flex-container-f1">
      <div class="flex-child magenta">
          <img src="'.$srcImgConsumo.'" class="imgFrt" alt="img">
      </div>
      <div class="flex-child green">
          <img src="'.$srcImgDesviacion.'" class="imgFrt"  alt="img">
      </div>
  </div>
  <div class="flex-container-f1">
      <div class="flex-child titulo" style="text-align:center;background-color: #C5C5C5;font-weight: bold;">
          FACTOR M (APLICA SUPERIOR 10 DÍAS)
      </div>
      <div class="flex-child titulo" style="text-align:center;background-color: #C5C5C5;font-weight: bold;">
          CONSUMO DE ENERGIAS EN EL MES
      </div>
  </div>
  <div class="flex-container-f1">
      <div class="flex-child magenta" style="text-align:center">
      <table align="center" style="width:100%; font-size: 15px;" border="1" cellspacing="0" cellpadding="2" bordercolor="666633">
        <tr>
          <td align="center"><strong>AÑO-MES</strong></td>
          <td align="center"><strong>FACTOR</strong></td>
          <td align="center"><strong>DIAS</strong></td>
          <td align="center"><strong>TIPO ENERGIA PENALIZADA</strong></td>
        </tr>
        '.$htmlFactorM.'
      </table>
      </div>
      <div class="flex-child green" style="text-align:center;background-color: #C5C5C5;font-weight: bold;">
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
      </div>
  </div>
  <div class="flex-container-f1">
      <div class="flex-child titulo" style="text-align:center;background-color: #C5C5C5;font-weight: bold;">
          COMPORTAMIENTO DE ENERGIA CAPACITIVA
      </div>
      <div class="flex-child titulo" style="text-align:center;background-color: #C5C5C5;font-weight: bold;">
          COMPORTAMIENTO DE ENERGIA INDUCTIVA
      </div>
  </div>
  <div class="flex-container-f1">
    <div class="flex-child titulo" style="text-align:justify;">
      Comportamiento generación energia capacitiva.
    </div>
    <div class="flex-child titulo" style="text-align:justify;">
    Comportamiento generación de energia inductiva.
    </div>
  </div>
  <div class="flex-container-f1">
      <div class="flex-child magenta">
          <img src="'.$srcImgCapacitiva.'" class="imgFrt" alt="img">
      </div>
      <div class="flex-child green">
          <img src="'.$srcImgPerdidas.'" class="imgFrt" alt="img">
      </div>
  </div>
</div>';
}
executeScriptToCreatePDF();
?>

