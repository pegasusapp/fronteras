 <div class="content-wrapper"> 
    <?= include_once 'breadcrumb.php' ?>
    <section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
         <div class="row">
                    <?php
                    $valor = $_SESSION["identificador"];
                   
                    $items = ControladorFronteras::crtMostrarTotalConsumoFronterasAnyoEnergia($valor); 
                    $k=1;
                    $name_plant="";
                    foreach ($items as $key => $value)
                      {
                        $sourceEnergy = $value["tipoEnergia"];
                        if($sourceEnergy == "A")
                          {
                           $class = "fa-bolt";
                           $sigla = "kWh";
                           $varColor="bg-info";
                            echo '<div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                              <span class="info-box-icon '.$varColor.' elevation-1"><i class="fas '.$class.'"></i></span>
                                  <div class="info-box-content">
                                  <span class="info-box-text"> '.$sigla.' consumidos
                                    <small>
                                        '.$value["anyoLectura"].'
                                    </small> 
                                  </span>
                                  
                                  <span class="info-box-number">
                                  '.number_format($value["total"]),'
                                  
                                  </span>
                                  
                                  </div>
                              </div>
                          </div>'; 
                         
                         }
                      }
                    //  <!---------------------------------------------------fin marcadores iniciales---------------------------------------------------------------------------->

                      $items = ControladorFronteras::crtMostrarTotalConsumoFronterasAnyoMesEnergia($valor);
                      $datosEstadisticos = array();
                      $anyos_comparativos = "";
                     
                      foreach ($items as $key => $value)
                      {
                         array_push($datosEstadisticos,array(
                           'anyo' => $value["anyoLectura"],
                           'mes' => $value["mesLectura"],
                           'valor'  => $value["total"]
                                 ));
                                 
                                   $name_plant ="Consumo de energia activa ";
                               
                                            
                      
                     }
                     $result = array();
                      foreach ($datosEstadisticos as $element) {
                          $result[$element['anyo']][] = $element;
                      }

                      $R = array(255,7,0);
                      $G = array(120,11,143);
                      $B = array(7,255,57); 
                      $datafills_php =""; 
                      $keys = array_keys($result);
                      $months = array('Ene.','Feb.',  'Mar.', 'Abr.',  'May',  'Jun.',  'Jul.',  'Ago.',  'Sep.',  'Oct.', 'Nov.', 'Dic.');
                      $labels = "";
                      $data = "";
                      $datasets = "";
                     
                      $A = 1;
					  
             
                      for($i = 0; $i < count($result); $i++)
                       {
                       
                               $data = "";  
                               $anyos_comparativos.=  $keys[$i]." vs ";
							                 $arrayMeses = array('','','','','','','','','','','','');
                              foreach($result[$keys[$i]] as $key => $value) 
                                {
								                   $arrayMeses[$value["mes"]-1] = round($value["valor"],3);	
							    							   $data.= "'".round($value["valor"],3)."',"; 
                                 }
								               $valor_mes_por_comas = implode(",", $arrayMeses);
								               $data =  substr( $data , 0 , -1);
                               $datasets.= "{";
                               $datasets.= "label               : 'Año ". $keys[$i] ." ".$sigla."',
                                              backgroundColor     : 'rgba($R[$i],$G[$i],$B[$i],$A)',
                                              borderColor         : 'rgba($R[$i],$G[$i],$B[$i],".floatval($A-0.4).")',
                                              pointRadius          : true,
                                              pointColor          : 'rgba($R[$i],$G[$i],$B[$i],$A)',
                                              pointStrokeColor    : 'rgba($R[$i],$G[$i],$B[$i],".floatval($A+0.1).")',
                                              pointHighlightFill  : '#fff',
                                              pointHighlightStroke: 'rgba($R[$i],$G[$i],$B[$i],".floatval($A+0.1).")',
                                              data                : [".$valor_mes_por_comas."]"; 
                                $datasets.= "},";
                                $datafills_php.="lineChartData.datasets[".$i."].fill = false;";
                                   
                             

                          }
                      ?>
         </div>
         <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Indicador - <?php  echo "  "; echo $name_plant; ?> </h5>

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
  <form name="frm1"  id="frm1" method="POST" >
    <input type="hidden" name="val_planta" id="val_planta" value="" />
    <input type="hidden" name="item_planta" id="item_planta" value="idproyecto" />
    <input type="hidden" name="val_tipo_energia" id="val_tipo_energia" value="" />
    <input type="hidden" name="item_tipo_energia" id="item_tipo_energia" value="fuenteEnergia_idfuenteEnergia" />
  </form>
  <form name="frm2"  id="frm2" method="POST" >
    <input type="hidden" name="fuenteEnergia_idfuenteEnergia" id="fuenteEnergia_idfuenteEnergia" value="" />
    <input type="hidden" name="grupoProyecto_idgrupoProyecto" id="grupoProyecto_idgrupoProyecto" value="" />

  </form>
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