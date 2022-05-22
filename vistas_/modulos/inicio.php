 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
<!------------------------------------------------------------------------------------------------------------------------------->

        <div class="row">

      
         
               <?php
                      $checkE = "checked";
                      $checkF = ""; 
                     if(!empty($_POST["val_tipo_energia"]))
                      {
                        if($_POST["val_tipo_energia"] == 1){ $checkE= "checked"; $checkF="";}
                        if($_POST["val_tipo_energia"] == 2){ $checkF= "checked"; $checkE= "";}
                      }
                   
                  
                    
                    
                     
                     if(!empty($_POST["item_planta"]) and !empty($_POST["val_planta"])) 
                        {
                          $item  =  $_POST["item_planta"];
                          $valor =  $_POST["val_planta"];
                          $item2  =  $_POST["item_tipo_energia"];
                          $valor2 = $_POST["val_tipo_energia"];
                          $filtro = $_POST["val_planta"];
                          $filtro2 = "";
                          $item3 = "";
                          $valor3 = "";
                        }
                     else
                        {
                          $item  =  "";
                          $valor =  "";
                          $item2  = "fuenteEnergia_idfuenteEnergia";
                          $valor2 = "1";
                          $filtro = NULL;
                          $filtro2 = "";
                          $item3 = "grupoProyecto_idgrupoProyecto";
                          $valor3 = "1"; 
                        }
                    $grupo1 = "anyo";
                    $grupo2 = "proyecto_idproyecto";
                   
                    $items = ControladorTotales::ctrMostrarTotalesResumenConsumo($grupo1,$grupo2,$filtro,$item2,$valor2,$item3,$valor3); 
                    $k=1;
                    $name_plant="";
                    foreach ($items as $key => $value)
                      {
                        $varColor ="bg-success";
                        $sourceEnergy = $value["fuenteEnergia_idfuenteEnergia"];
                        if($sourceEnergy == 1)
                          {
                           $class = "fa-bolt";
                           $sigla = "kWh";
                           $varColor="bg-info";
                           $tipoIndicador = "IDE electricidad";
                          }
                         else
                         {
                          $class = "fa-fire";
                          $sigla = "Kg";
                          $varColor="bg-danger";
                          $tipoIndicador = "IDE carbón";
                         }
                    
                       
                        echo '<div class="col-12 col-sm-6 col-md-3">
                                <div class="info-box">
                                  <span class="info-box-icon '.$varColor.' elevation-1"><i class="fas '.$class.'"></i></span>
                                     <div class="info-box-content">
                                      <span class="info-box-text"> '.$sigla.' consumidos en el año
                                        <small>
                                           '.$value["anyo"].'
                                        </small> 
                                      </span>
                                      
                                      <span class="info-box-number">
                                      '.number_format($value["total"]),'
                                      
                                      </span>
                                     
                                     </div>
                                 </div>
                              </div>';   
                                      
                      }
                   
                     
                      
                       $items = ControladorProduccion::ctrMostrarkhwtonDash($item,$valor,$item2,$valor2,$item3,$valor3);
                       $datosEstadisticos = array();
                       $anyos_comparativos = "";
                      
                       foreach ($items as $key => $value)
                       {
                          array_push($datosEstadisticos,array(
                            'anyo' => $value["anyo"],
                            'mes' => $value["mes"],
                            'valor'  => $value["indicador"]
                                  ));
                                  if(!empty($_POST["item_planta"]) and !empty($_POST["val_planta"])) 
                                  {
                                    
                                    $name_plant =$value["nombrePlanta"];
                                  }
                                  else {
                                    $name_plant =" de las plantas italcol";
                                  }
                                             
                       
                      }
                      $result = array();
                      foreach ($datosEstadisticos as $element) {
                          $result[$element['anyo']][] = $element;
                      }
                     
                      
            
                                    $datafills_php =""; 
                                    $keys = array_keys($result);
                                    $months = array('Ene.','Feb.',  'Mar.', 'Abr.',  'May',  'Jun.',  'Jul.',  'Ago.',  'Sep.',  'Oct.', 'Nov.', 'Dic.');
                                    $labels = "";
                                    $data = "";
                                    $datasets = "";
                                    $R = 60;
                                    $G = 141;
                                    $B = 188;
                                    $A = 1;

                                  
                                    for($i = 0; $i < count($result); $i++)
                                     {
                                     
                                             $data = "";  
                                             $anyos_comparativos.=  $keys[$i]." vs ";
                                            foreach($result[$keys[$i]] as $key => $value) 
                                              {
                                              
                                                  $data.= "'".$value["valor"]."',"; 
                                                 
                                              
                                              }
                                              
                                             $data =  substr( $data , 0 , -1);
                                          
                                             $datasets.= "{";
                                              $datasets.= "label               : 'Año ". $keys[$i] ." ".$sigla."/Ton',
                                                            backgroundColor     : 'rgba($R,$G,$B,$A)',
                                                            borderColor         : 'rgba($R,$G,$B,".floatval($A-0.1).")',
                                                            pointRadius          : true,
                                                            pointColor          : 'rgba($R,$G,$B,$A)',
                                                            pointStrokeColor    : 'rgba($R,$G,$B,".floatval($A+0.1).")',
                                                            pointHighlightFill  : '#fff',
                                                            pointHighlightStroke: 'rgba($R,$G,$B,".floatval($A+0.1).")',
                                                            data                : [".$data."]"; 
                                              $datasets.= "},";
                                              
                                              $R = $R + 80;
                                              $G = $G + 20;
                                              $B = $B + 5;
                      
                                              $datafills_php.="lineChartData.datasets[".$i."].fill = false;";
                                                 
                                           
            
                                        }
                                        $anyos_comparativos= substr( $anyos_comparativos , 0 , -3);
                                        
                                    ?>   
        </div>   
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Indicador - <?php echo $tipoIndicador; echo "  "; echo $name_plant; ?> </h5>

                <div class="card-tools">
                
                      <div class="btn-group">
                        <button type="button" class="btn btn-tool" data-toggle="dropdown">
                          <i class="fas fa-lightbulb"></i>
                        </button>
                        <input type="radio" id="tipoE" name="tipo_energia" value="1"  <?php echo $checkE; ?> />
                      </div>
                      <div class="btn-group">
                        <button type="button" class="btn btn-tool" data-toggle="dropdown">
                          <i class="fas fa-fire-alt"></i>
                        </button>
                        <input type="radio" id="tipoC" name="tipo_energia" value="2"  <?php echo $checkF; ?> / >
                      </div>
                    <?php 
                       $item_p  = null;
                       $valor_p = null;
                       $items_p = ControladorProyectos::ctrMostrarGruposProyecto($item_p,$valor_p);
                       
                       foreach($items_p as $llave => $valorIn)
                       {
                            
                            $item = "grupoProyecto_idgrupoProyecto";
                            $valor = $valorIn["idgrupoProyecto"];
                            $item2 = "seguimiento";
                            $valor2 = 1;
                            $items = ControladorProyectos::ctrMostrarProyectoSimple($item,$valor,$item2,$valor2);
                            echo '<div class="btn-group">
                                      <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas '.$valorIn["icono"].'"></i>
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-right" role="menu">
                                  ';
                            foreach ($items as $key => $value)
                              {
                                echo '
                                        <a href="#" onClick="reloadGraph_uno('.$value["idproyecto"].')" style="font-size:12px;" class="dropdown-item">'.$value["nombrePlanta"].'</a>
                                     ';
                              }
                              echo '
                                     </div>
                                  </div>
                                   ';
                        }
                    ?>
                  <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button> -->
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-7">
                    <p class="text-center">
                      <strong><?php echo $sigla;?>/Ton (<?php echo $anyos_comparativos;  ?>)</strong>
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
                      <canvas id="salesChart_indice" height="180" style="height: 180px; display: block; width: 680px;" width="980" class="chartjs-render-monitor"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-5">
                    <p class="text-center">
                      <strong>Datos estadisticos</strong>
                    </p>
                      <?php

                          if(!empty($_POST["item_planta"]) and !empty($_POST["val_planta"])) 
                          {
                            $item  =  $_POST["item_planta"];
                            $valor =  $_POST["val_planta"];
                            $item2  =  $_POST["item_tipo_energia"];
                            $valor2 = $_POST["val_tipo_energia"]; 
                            $filtro = $_POST["val_planta"]; 
                            $item3 = "";
                            $valor3 = ""; 
                          }
                          else
                          {
                            $item  =  "";
                            $valor =  "";
                            $item2  = "fuenteEnergia_idfuenteEnergia";
                            $valor2 = "1";
                            $item3 = "grupoProyecto_idgrupoProyecto";
                            $valor3 = "1"; 
                          }

                        $fun="DESC";

                        $items = ControladorProduccion::ctrMostrarProduccionIndicador($fun,$item,$valor,$item2,$valor2,$item3,$valor3);
                      
                        //$datosEstadisticos_max = array();
                        foreach ($items as $key => $value)
                          {
                           
                           $pinta_barra=$value["avg_rate"];
                           //if($value["avg_rate"] > 100){$pinta_barra=$value["avg_rate"]/10;}
                            echo '
                              <div class="progress-group">
                                <span class="progress-text">Máx. Indicador energetico a la fecha-> 
                                <b> '.number_format($value["avg_rate"], 2, '.', ' ').'</b> Ocurrido en '.$value["mes"].' de '.$value["anyo"].'</span>
                                <div class="progress progress-sm">
                                  <div class="progress-bar bg-danger" style="width: '.$pinta_barra.'%"></div>
                                </div>
                              </div>';
                          }
                      
                        $fun="ASC";
                        $items = ControladorProduccion::ctrMostrarProduccionIndicador($fun,$item,$valor,$item2,$valor2,$item3,$valor3);
                     
                        //$datosEstadisticos_min = array();
                        foreach ($items as $key => $value)
                        {
                          $pinta_barra=$value["avg_rate"];

                        
                          //if($value["avg_rate"] > 100){$pinta_barra=$value["avg_rate"]/10;}
                          echo '<div class="progress-group">
                                  <span class="progress-text">Min. Indicador energetico a la fecha-> 
                                  <b> '.number_format($value["avg_rate"], 2, '.', ' ').'</b> Ocurrido en '.$value["mes"].' de '.$value["anyo"].'</span>
                                  <div class="progress progress-sm">
                                    <div class="progress-bar bg-success" style="width: '. $pinta_barra.'%"></div>
                                  </div>
                                </div>';
                        }
                     ?>    
                    <!-- /.progress-group 
                    <div class="progress-group">
                      Send Inquiries
                      <span class="float-right"><b>250</b>/500</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" style="width: 50%"></div>
                      </div>
                    </div>
                   progress-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
     
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                    <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 5.10%</span>
                      <h5 class="description-header">2018(23.5) vs 2019(22.3)</h5>
                      <span class="description-text">Reducción IDE</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 6.74%</span>
                      <h5 class="description-header">1.807.924 TON</h5>
                      <span class="description-text">Total producción 2019</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i></span>
                      <h5 class="description-header">1.685.997 TON</h5>
                      <span class="description-text">Total producción 2018</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block">
                      <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i></span>
                      <h5 class="description-header">2019(22.3) vs 2020(21.79)</h5>
                      <span class="description-text">Reduccion IDE</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
      
     <!-- ./col -->
     </div>
        <!-- /.row -->



<!------------------------------------------------------------------------------------------------------------------------------->


        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <form name="frm1"  id="frm1" method="POST" >
    <input type="hidden" name="val_planta" id="val_planta" value="" />
    <input type="hidden" name="item_planta" id="item_planta" value="idproyecto" />
    <input type="hidden" name="val_tipo_energia" id="val_tipo_energia" value="" />
    <input type="hidden" name="item_tipo_energia" id="item_tipo_energia" value="fuenteEnergia_idfuenteEnergia" />
  </form>
  <script>

function reloadGraph_uno(valor)
{
  var eleCheck = document.getElementsByName('tipo_energia'); 
              
              for(i = 0; i < eleCheck.length; i++) 
              { 
                  if(eleCheck[i].checked)
                   {
                    document.getElementById("val_tipo_energia").value = eleCheck[i].value;
                   } 
                   
              } 
  document.getElementById("val_planta").value = valor;
  document.getElementById('frm1').submit();
}
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
      display: false
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