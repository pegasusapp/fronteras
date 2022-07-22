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
    $htmlFactorM="";
    $arrayDataFactorM = ControladorCtrFactorM::ctrMostrarctrFactorMLastThreMonths($valor["fronteraCliente"]);
        
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
                                 <td align="center">'.$vlr["anyo"].'</td> 
                                 <td align="center">'.$vlr["mes"].'</td> 
                                 <td align="center" bgcolor="'.$bgcolor.'">'.$vlr["factor"].'</td> 
                                 <td align="center" bgcolor="'.$bgcolor.'">'.$vlr["dias"].'</td>
                                 <td align="center">'.$vlr["tipoEnergia"].'</td>
                            </tr>'; 
        }
        
    
    
    
  
$content='<style> #customers { font-family: Arial, Helvetica, sans-serif; border-collapse: collapse; width: 100%; } #customers td, #customers th { border: 1px solid #ddd; padding: 8px; } #customers tr:nth-child(even){background-color: #f2f2f2;} #customers tr:hover {background-color: #ddd;} #customers th { padding-top: 12px; padding-bottom: 12px; text-align: left; background-color: #04AA6D; color: white; } .u-repeater { flex-grow: 1; flex-shrink: 1; flex-basis: auto; } .u-repeater { display: grid; grid-template-columns: repeat(4, 25%); } .u-align-center { text-align: center; } .u-section-5 .u-text-1 { font-weight: 700; font-size: 3rem; margin: 20px 0 0; } .u-text-palette-2-base, li.active > a.u-button-style.u-text-palette-2-base, li.active > a.u-button-style.u-text-palette-2-base[class*="u-border-"], a.u-button-style.u-text-palette-2-base, a.u-button-style.u-text-palette-2-base[class*="u-border-"] { color: #db545a !important; } .u-section-5 .u-icon-1 { width: 64px; background-image: none; margin: 0 auto; } .u-icon { display: block; line-height: 0; border-width: 0px; } #block_container { text-align:center; } #bloc1, #bloc2 { display:inline; } .gfg { width:auto; text-align:center; padding:20px; } .imgFrtConsumo { width:80%; height:auto; } .imgFrtDesviacion { width:80%; height:auto; } .imgFrt { width:80%; height:auto; } </style> <table id="customers" align="center" style="width:100%; font-size: 13px;" border="1" cellspacing="0" cellpadding="2" bordercolor="666633"> <tr> <td width="15%" height="50"><img align="center" src="https://fronteras.energiaitalener.com/controladores/template/images/logo-blanco-bloque.png"  ></td> <td width="33%" height="50" colspan="4" style="text-align: center;"><strong>REPORTE DIARIO RELACIONADO CON LA FRONTERA - '.$valor["fronteraCliente"].'</strong></td> </tr><tr><td colspan="5" align="center" bgcolor="#bcc1d1"><strong>COMPARACION DE CONSUMOS</strong></td> </tr> <tr> <td colspan="5"> La siguiente grafica nos muestra el consumo hasta el dia de ayer, comparado con el consumo hasta el mismo dia del mes anterior. </td> </tr> <tr> <td colspan="5" align="center"><img class="imgFrtConsumo" src="https://fronteras.energiaitalener.com/controladores/template/images/'.$valor["fronteraCliente"].'_consumo.png"></td> </tr> <tr> <td colspan="5" align="center" bgcolor="#bcc1d1"><strong>DESVIACION SIGNIFICATIVA</strong></td> </tr> <tr> <td colspan="5">El consumo promedio del dia anterior con respecto al mes pasado fue de '.$total_dia_avg.', el consumo del día anterior fue de '.$total_dia_last.'. Ud  <strong>'.$desviado.'</strong> presenta desviación </td> </tr> <tr> <td colspan="5" align="center"><img class="imgFrtDesviacion" src="https://fronteras.energiaitalener.com/controladores/template/images/'.$valor["fronteraCliente"].'_desviacion.png"  ></td></tr><tr><td colspan="5" style="padding-bottom: 100px;"></td></tr><tr> <td colspan="5" align="center" bgcolor="#bcc1d1"><strong>FACTOR M</strong></td> </tr> <tr> <td colspan="5">En la siguiente tabla podra ver el historial de los ultimos TRES meses del factor M de su frontera</td> </tr> <tr> <td align="center"><strong>ANO</strong></td><td align="center"><strong>MES</strong></td><td align="center"><strong>VALOR</strong></td><td align="center"><strong>DIAS</strong></td><td align="center"><strong>TIPO ENERGIA</strong></td> </tr>'.$htmlFactorM.'<tr><td colspan="5" style="padding-bottom: 75px;"></td></tr> <tr> <td colspan="5" align="center" bgcolor="#bcc1d1"><strong>CONSUMO DE ENERGIAS EN EL MES</strong></td> </tr> <tr> <td align="center"><img src="https://fronteras.energiaitalener.com/controladores/template/images/3103468.png"  alt=""></td> <td align="center"><img src="https://fronteras.energiaitalener.com/controladores/template/images/1015595.png"  alt=""></td> <td align="center"><img src="https://fronteras.energiaitalener.com/controladores/template/images/1835596.png"  alt=""></td> <td align="center"><img src="https://fronteras.energiaitalener.com/controladores/template/images/4343051.png"  alt=""></td> </tr> <tr> <td align="center"><h3 class="u-custom-font u-font-montserrat u-text u-text-palette-2-base u-text-1" data-animation-name="counter" data-animation-event="scroll" data-animation-duration="3000">2.105</h3></td> <td align="center"><h3 class="u-custom-font u-font-montserrat u-text u-text-palette-2-base u-text-3" data-animation-name="counter" data-animation-event="scroll" data-animation-duration="3000"> 3.158</h3></td> <td align="center"><h3 class="u-custom-font u-font-montserrat u-text u-text-palette-2-base u-text-5" data-animation-name="counter" data-animation-event="scroll" data-animation-duration="3000">297</h3></td> <td align="center"><h3 class="u-custom-font u-font-montserrat u-text u-text-palette-2-base u-text-7" data-animation-name="counter" data-animation-event="scroll" data-animation-duration="3000"> 5.282</h3></td> </tr> <tr> <td align="center"><h4 class="u-custom-font u-font-montserrat u-text u-text-2">Activa</h4></td> <td align="center"><h4 class="u-custom-font u-font-montserrat u-text u-text-4">Reactiva</h4></td> <td align="center"><h4 class="u-custom-font u-font-montserrat u-text u-text-6">Capacitiva</h4></td> <td align="center"><h4 class="u-custom-font u-font-montserrat u-text u-text-8">Penalizada</h4></td> </tr<tr><td colspan="5" style="padding-bottom: 10px;"></td></tr>>
<tr> <td colspan="5" align="center" bgcolor="#bcc1d1"><strong>COMPORTAMIENTO DE ENERGIA CAPACITIVA Y PENALIZACIONES</strong></td> </tr> <tr> <td colspan="5">En la siguientes imagenes se pueden contemplar los comportamientos de la energia capacitiva y las penalizaciones generadas</td> </tr> <tr > <td colspan="5" align="center"><img class="imgFrt" src="https://fronteras.energiaitalener.com/controladores/template/images/'.$valor["fronteraCliente"].'_capacitiva.png"></td></tr><tr> <td colspan="5" align="center"> <img class="imgFrt" src="https://fronteras.energiaitalener.com/controladores/template/images/'.$valor["fronteraCliente"].'_perdidas.png"></td> </tr> </table>';
$dompdf = new Dompdf();
$dompdf->loadHtml($content);
$dompdf->set_option('enable_remote', TRUE);
$dompdf->set_option('enable_css_float', TRUE);
$dompdf->set_option('enable_html5_parser', FALSE);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
file_put_contents("invoice-" . $valor["fronteraCliente"] . ".pdf",  $dompdf->output());
}
?>