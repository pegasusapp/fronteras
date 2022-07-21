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
    ob_start();
    $html='<body class="u-body u-xl-mode" data-lang="en">
    <header class="u-clearfix u-header u-header" id="sec-3983">
      <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
        <img src="'.dirname(__FILE__).'/images/logo-blanco-bloque.png" class="u-logo-image u-logo-image-1">
     </div></header>
  <section class="skrollable skrollable-between u-align-center u-clearfix u-white u-section-1" src="" id="carousel_0ac8">
    <h2 class="u-text u-text-default-lg u-text-default-md u-text-default-xl u-text-1">Reporte diario<br>
    </h2>
    <p class="u-large-text u-text u-text-variant u-text-2">A continuación encontraras detalle del comportamiento del día anterior de la frontera '.$valor["fronteraCliente"].'<br>
    </p>
    <div class="u-list u-list-1">
      <div class="u-repeater u-repeater-1">
        <div class="u-align-center u-border-5 u-border-palette-2-base u-container-style u-list-item u-repeater-item u-shape-rectangle u-white u-list-item-1">
          <div class="u-container-layout u-similar-container u-container-layout-1"><span class="u-file-icon u-icon u-icon-rounded u-text-palette-2-base u-white u-icon-1"><img src="images/3649107.png" alt=""></span>
            <h4 class="u-text u-text-3">Desviación significativa<br>
            </h4>
          </div>
        </div>
        <div class="u-align-center u-border-5 u-border-palette-2-base u-container-style u-list-item u-repeater-item u-shape-rectangle u-white u-list-item-2">
          <div class="u-container-layout u-similar-container u-container-layout-2"><span class="u-file-icon u-icon u-icon-rounded u-text-palette-2-base u-white u-icon-2"><img src="images/2628908.png" alt=""></span>
            <h4 class="u-text u-text-4">Comparacíon de consumos <br>
            </h4>
          </div>
        </div>
        <div class="u-align-center u-border-5 u-border-palette-2-base u-container-style u-list-item u-repeater-item u-shape-rectangle u-white u-list-item-3">
          <div class="u-container-layout u-similar-container u-container-layout-3"><span class="u-file-icon u-icon u-icon-rounded u-text-palette-2-base u-white u-icon-3"><img src="images/2674240.png" alt=""></span>
            <h4 class="u-text u-text-5">Factor M<br>
            </h4>
          </div>
        </div>
        <div class="u-align-center u-border-5 u-border-palette-2-base u-container-style u-list-item u-repeater-item u-shape-rectangle u-white u-list-item-4">
          <div class="u-container-layout u-similar-container u-container-layout-4"><span class="u-file-icon u-icon u-icon-rounded u-text-palette-2-base u-white u-icon-4"><img src="images/2997240.png" alt=""></span>
            <h4 class="u-text u-text-6">Energia Capacitiva y penalización<br>
            </h4>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="u-align-center u-clearfix u-grey-5 u-section-2" id="carousel_d044">
    <div class="u-clearfix u-sheet u-sheet-1">
      <div class="u-border-2 u-border-palette-4-light-1 u-shape u-shape-rectangle u-shape-1"></div>
      <div class="u-clearfix u-gutter-20 u-layout-wrap u-layout-wrap-1">
        <div class="u-gutter-0 u-layout">
          <div class="u-layout-row">
            <div class="u-container-style u-layout-cell u-size-60 u-white u-layout-cell-1">
              <div class="u-container-layout u-container-layout-1">
                <h3 class="u-align-center u-text u-text-default u-text-1">Comparación de consumos<br>
                </h3>
                <p class="u-align-center u-text u-text-grey-40 u-text-2">La siguiente gráfica nos muestra el consumo hasta el día de ayer, comparado con el consumo hasta el mismo día del mes anterior.<br>
                </p>
                <img class="u-image u-image-default u-image-1" src="images/<?= $data["frontera"] ?>_consumo.png" alt="" data-image-width="1000" data-image-height="600">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="u-clearfix u-palette-2-light-1 u-section-3" id="carousel_a626">
    <div class="u-expanded-width u-grey-5 u-shape u-shape-rectangle u-shape-1"></div>
    <div class="u-clearfix u-layout-wrap u-layout-wrap-1">
      <div class="u-layout">
        <div class="u-layout-row">
          <div class="u-container-style u-image u-layout-cell u-size-20-lg u-size-20-xl u-size-30-md u-size-30-sm u-size-30-xs u-image-1" data-image-width="1004" data-image-height="871">
            <div class="u-container-layout u-container-layout-1"></div>
          </div>
          <div class="u-align-center u-black u-container-style u-layout-cell u-size-14-lg u-size-14-xl u-size-30-md u-size-30-sm u-size-30-xs u-layout-cell-2">
            <div class="u-container-layout u-valign-top u-container-layout-2">
              <h3 class="u-text u-text-default u-text-1">Desviación significativa<br>
              </h3>
              <p class="u-text u-text-default u-text-2">El&nbsp; consumo promedio del dia anterior con respecto al mes pasado fue de <?=$data["consumoPromedio"] ?>, el consumo del día anterior fue de <?=$data["consumoAnterior"] ?>. Ud <?=$data["desviado"] ?> presenta desviación<br>
              </p>
            </div>
          </div>
          <div class="u-align-left u-container-style u-layout-cell u-size-26-lg u-size-26-xl u-size-60-md u-size-60-sm u-size-60-xs u-white u-layout-cell-3">
            <div class="u-container-layout u-container-layout-3">
              <img class="u-image u-image-default u-image-2" src="images/<?= $data["frontera"] ?>_desviacion.png" alt="" data-image-width="1000" data-image-height="600">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="u-clearfix u-valign-top u-section-4" id="carousel_f315">
    <div class="u-expanded-width u-grey-10 u-shape u-shape-rectangle u-shape-1"></div>
    <div class="u-palette-1-light-2 u-shape u-shape-rectangle u-shape-2"></div>
    <img src="images/vbb.jpg" alt="" class="u-image u-image-default u-image-1" data-image-width="1000" data-image-height="1000">
    <div class="u-container-style u-group u-white u-group-1">
      <div class="u-container-layout u-container-layout-1">
        <h3 class="u-text u-text-1">Factor M<br>
        </h3>
        <h6 class="u-text u-text-2">En la siguiente tabla podá ver el historial de los úitmos seis meses del factor M de su frontera<br>
        </h6>
        <div class="u-table u-table-responsive u-table-1">
          <table class="u-table-entity">
            <colgroup>
              <col width="50%">
              <col width="50%">
            </colgroup>
            <thead class="u-palette-4-base u-table-header u-table-header-1">
              <tr style="height: 47px;">
                <th class="u-border-1 u-border-palette-4-base u-table-cell">Mes</th>
                <th class="u-border-1 u-border-palette-4-base u-table-cell">Factor</th>
              </tr>
            </thead>
            <tbody class="u-table-body">
              <tr style="height: 49px;">
                <td class="u-border-1 u-border-grey-30 u-first-column u-grey-5 u-table-cell u-table-cell-3">Row 1</td>
                <td class="u-border-1 u-border-grey-30 u-table-cell">Description</td>
              </tr>
              <tr style="height: 50px;">
                <td class="u-border-1 u-border-grey-30 u-first-column u-grey-5 u-table-cell u-table-cell-5">Row 2</td>
                <td class="u-border-1 u-border-grey-30 u-table-cell">Description</td>
              </tr>
              <tr style="height: 50px;">
                <td class="u-border-1 u-border-grey-30 u-first-column u-grey-5 u-table-cell u-table-cell-7">Row 3</td>
                <td class="u-border-1 u-border-grey-30 u-table-cell">Description</td>
              </tr>
              <tr style="height: 50px;">
                <td class="u-border-1 u-border-grey-30 u-first-column u-grey-5 u-table-cell u-table-cell-9">Row 4</td>
                <td class="u-border-1 u-border-grey-30 u-table-cell">Description</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  <section class="u-align-center u-clearfix u-section-5" id="carousel_b5a8">
    <div class="u-clearfix u-sheet u-sheet-1">
      <div class="u-expanded-width u-list u-list-1">
        <div class="u-repeater u-repeater-1">
          <div class="u-align-center u-container-style u-grey-5 u-list-item u-repeater-item u-list-item-1">
            <div class="u-container-layout u-similar-container u-valign-top u-container-layout-1"><span class="u-file-icon u-icon u-icon-1" data-animation-name="" data-animation-duration="0" data-animation-delay="0" data-animation-direction=""><img src="images/3103468.png" alt=""></span>
              <h3 class="u-custom-font u-font-montserrat u-text u-text-palette-2-base u-text-1" data-animation-name="counter" data-animation-event="scroll" data-animation-duration="3000">2.105</h3>
              <h4 class="u-custom-font u-font-montserrat u-text u-text-2">ACTIVA</h4>
            </div>
          </div>
          <div class="u-align-center u-container-style u-grey-5 u-list-item u-repeater-item u-list-item-2">
            <div class="u-container-layout u-similar-container u-valign-top u-container-layout-2"><span class="u-file-icon u-icon u-icon-2" data-animation-name="" data-animation-duration="0" data-animation-delay="0" data-animation-direction=""><img src="images/1015595.png" alt=""></span>
              <h3 class="u-custom-font u-font-montserrat u-text u-text-palette-2-base u-text-3" data-animation-name="counter" data-animation-event="scroll" data-animation-duration="3000"> 3.158</h3>
              <h4 class="u-custom-font u-font-montserrat u-text u-text-4">Reactiva</h4>
            </div>
          </div>
          <div class="u-align-center u-container-style u-grey-5 u-list-item u-repeater-item u-list-item-3">
            <div class="u-container-layout u-similar-container u-valign-top u-container-layout-3"><span class="u-file-icon u-icon u-icon-3" data-animation-name="" data-animation-duration="0" data-animation-delay="0" data-animation-direction=""><img src="images/1835596.png" alt=""></span>
              <h3 class="u-custom-font u-font-montserrat u-text u-text-palette-2-base u-text-5" data-animation-name="counter" data-animation-event="scroll" data-animation-duration="3000">297</h3>
              <h4 class="u-custom-font u-font-montserrat u-text u-text-6">capacitiva<br>
              </h4>
            </div>
          </div>
          <div class="u-align-center u-container-style u-grey-5 u-list-item u-repeater-item u-list-item-4">
            <div class="u-container-layout u-similar-container u-valign-top u-container-layout-4"><span class="u-file-icon u-icon u-icon-4" data-animation-name="" data-animation-duration="0" data-animation-delay="0" data-animation-direction=""><img src="images/4343051.png" alt=""></span>
              <h3 class="u-custom-font u-font-montserrat u-text u-text-palette-2-base u-text-7" data-animation-name="counter" data-animation-event="scroll" data-animation-duration="3000"> 5.282</h3>
              <h4 class="u-custom-font u-font-montserrat u-text u-text-8">penalizada<br>
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="u-clearfix u-section-6" id="sec-3d9b">
    <div class="u-clearfix u-sheet u-sheet-1">
      <h4 class="u-text u-text-default u-text-1">Comportamientos de la energía capacitiva y las perdidas<br>
      </h4>
      <div class="u-clearfix u-expanded-width u-layout-wrap u-layout-wrap-1">
        <div class="u-layout">
          <div class="u-layout-row">
            <div class="u-container-style u-layout-cell u-size-30 u-layout-cell-1">
              <div class="u-container-layout u-valign-middle u-container-layout-1">
                <img class="u-image u-image-1" src="images/Frt41351_capacitiva.png" data-image-width="1000" data-image-height="600">
              </div>
            </div>
            <div class="u-container-style u-layout-cell u-size-30 u-layout-cell-2">
              <div class="u-container-layout u-container-layout-2">
                <img class="u-image u-image-default u-image-2" src="images/Frt41351_perdidas.png" alt="" data-image-width="1000" data-image-height="600">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>    
  <footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" id="sec-21c8"><div class="u-clearfix u-sheet u-sheet-1">
      <p class="u-small-text u-text u-text-variant u-text-1">SoftFocus 2022<br>
      </p>
    </div></footer></body>';

$dompdf->loadHtml($html);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
//$dompdf->stream();
//print the pdf file to the screen for saving
$file_to_save = ["idorden"].'.pdf';
//save the pdf file on the server
file_put_contents("invoice-" . $valor["fronteraCliente"] . ".pdf",  $dompdf->output());

header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="file.pdf"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($file_to_save));
header('Accept-Ranges: bytes');
readfile($file_to_save);

}
?>