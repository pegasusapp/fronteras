<?php
      $valor = "";
      if($_SESSION["perfilSesion"] <> 9)
      {
        $valor = $_SESSION["identificador"];
      }
    $items = ControladorFronteras::crtMostrarTotalConsumoFronterasAnyoEnergia($valor);
    $items_total_csm_frt_anyo_mes = ControladorFronteras::crtMostrarTotalConsumoFronterasAnyoMesEnergia($valor);

    $R = array(255,7,0);
    $G = array(120,11,143);
    $B = array(7,255,57);
    $A = 1;
    $i=0;
    foreach ($items_total_csm_frt_anyo_mes as $value)
      {
          $datasets.= "{";
          $datasets.= "label               : 'Año ". $value["anyoLectura"] ." kWh',
                        backgroundColor     : 'rgba($R[$i],$G[$i],$B[$i],$A)',
                        borderColor         : 'rgba($R[$i],$G[$i],$B[$i],".floatval($A-0.4).")',
                        pointRadius          : true,
                        pointColor          : 'rgba($R[$i],$G[$i],$B[$i],$A)',
                        pointStrokeColor    : 'rgba($R[$i],$G[$i],$B[$i],".floatval($A+0.1).")',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba($R[$i],$G[$i],$B[$i],".floatval($A+0.1).")',
                        data                : [". $value["total"]."]";
          $datasets.= "},";
          $datafills_php.="lineChartData.datasets[".$i."].fill = false;";
          $i++;
        }
?>
<section class="content">
    <div class="container-fluid">
         <div class="row">
                    
             <?php foreach ($items as $value):?>
                      
                      <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                              <span class="info-box-icon bg-info elevation-1"><em class="fas fa-bolt"></em></span>
                                  <div class="info-box-content">
                                    <span class="info-box-text"> kWh consumidos
                                      <small>
                                          <?= $value["anyoLectura"] ?>
                                      </small> 
                                    </span>
                                    <span class="info-box-number">
                                         <?= number_format($value["total"])?>
                                    </span>
                                  </div>
                              </div>
                          </div> 
              <?php endforeach;?>           
         </div>
         <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Indicador - Consumo de energia activa  </h5>

                <div class="card-tools">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <p class="text-center">
                      <strong>Fronteras del cliente</strong>
                    </p>

                    <div class="chart">
                          <div class="chartjs-size-monitor">
                              <div class="chartjs-size-monitor-expand">
                                  <div class="">
                                  </div>
                              </div>
                              <div class="chartjs-size-monitor-shrink">
                                  <div class="">
                                  </div>
                              </div>
                          </div>
                      <!-- Sales Chart Canvas -->
                      <canvas id="salesChart_indice" height="360" style="height: 360px; display: block; width: 680px;" width="980" class="chartjs-render-monitor"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
       </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>
  <script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
//-----------------------
  //- MONTHLY SALES CHART -
  //-----------------------

  // Get context with jQuery - using jQuery's .get() method.
  var salesChartCanvas = $('#salesChart_indice').get(0).getContext('2d')

  var salesChartData = {
    labels  : ['Ene.', 'Feb.', 'Mar.', 'Abr.', 'May.', 'Jun.', 'Jul.', 'Ago.', 'Sep.', 'Oct.', 'Nov.', 'Dic.'],
    datasets: [ <?php
                     echo $datasets; 
                 ?> 
              ]
  }

  var salesChartOptions = {
    maintainAspectRatio : false,
    responsive : true,
    legend: {
      display: true
    },
      tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
    scales: {
      xAxes: [{
        gridLines : {
          display : false,
        }
      }],
      yAxes: [{
        gridLines : {
          display : false,
        }
      }]
    }
  }
 
  var lineChartOptions = jQuery.extend(true, {}, salesChartOptions)
  var lineChartData = jQuery.extend(true, {}, salesChartData)
   <?php 
         echo $datafills_php;
     ?>
    lineChartOptions.datasetFill = false

  // This will get the first returned node in the jQuery collection.
  var salesChart = new Chart(salesChartCanvas, { 
      type: 'line', 
      data: lineChartData, 
      options: lineChartOptions
    }
  )
  })


</script>