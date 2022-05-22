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
              <li class="breadcrumb-item active">Dashboard v1</li>
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
	       
	        $item = null;
	        $valor = null;
          $items = ControladorProyectos::ctrContarProyectos($item, $valor); 
          ?>
          
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>
                <?php
                foreach ($items as $key => $value)
		              {
                         echo  $value["cantidad"];
                  }
                  ?>
                </h3>
                <p>Plantas</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <?php
	       
         $item = "anyo";
         $items = ControladorProduccion::ctrMostrarProduccionNetaDash($item); 
         $k=1;         
         foreach ($items as $key => $value)
           {
            $varColor ="bg-success";
         
            if ($k%2==0){$varColor="bg-warning";}        
            echo '<div class="col-lg-4 col-6">
                           <div class="small-box '.$varColor.'">
                              <div class="inner">
                                <h3>'.number_format($value["toneladas"]).'</h3>
                                <p>Toneladas x año '.$value["anyo"].'</p>
                              </div>
                           <div class="icon">
                           <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                         </div>
                        </div>';
                        $k++;         
           }
           

         ?>       
          <?php
	       
         $item = null;
         $valor = null;
         $items = ControladorFuentes::ctrContarFuentes($item, $valor); 
         ?>
          <div class="col-lg-3 col-6">
           
            <div class="small-box bg-info">
              <div class="inner">
              <h3>
              <?php
                foreach ($items as $key => $value)
		              {
                         echo  $value["cantidad"];
                  }
                  ?>
              </h3>
              <p>fuentes energéticas</p>
              </div>
              <div class="icon">
                <i class="ion ion-leaf"></i>
              </div>
              <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
         
          <?php
	       
         $item = "anyo";
         $items = ControladorTotales::ctrMostrarTotalesResumen($item); 
         $k=1;          
         foreach ($items as $key => $value)
           {
            $varColor ="bg-success";
         
            if ($k%2==0){$varColor="bg-warning";}   
             echo '<div class="col-lg-4 col-6">
                           <div class="small-box '.$varColor.'">
                              <div class="inner">
                                <h3>$'.number_format($value["total"]).'</h3>
                                <p>Facturacion año '.$value["anyo"].'</p>
                              </div>
                           <div class="icon">
                           <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                         </div>
                        </div>';
              $k++;          
           }
           

         ?>
              <?php
	       
         $item = "fuenteEnergia_idfuenteEnergia";
         $valor = "1";
         $items = ControladorPerfiles::ctrMostrarPerfilesDash($item, $valor); 
         ?>
          <div class="col-lg-3 col-6">
           
            <div class="small-box bg-info">
              <div class="inner">
              <h3>
              <?php
                foreach ($items as $key => $value)
		              {
                         echo  $value["cantidad"];
                  }
                  ?>
              </h3>
              <p>perfiles de energía</p>
              </div>
              <div class="icon">
                <i class="ion ion-leaf"></i>
              </div>
              <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> 
          <?php
	       
         $item = "anyo";
         $items = ControladorTotales::ctrMostrarTotalesResumenConsumo($item); 
         $k=1;
         foreach ($items as $key => $value)
           {
            $varColor ="bg-success";
         
            if ($k%2==0){$varColor="bg-warning";}  
            echo '<div class="col-lg-4 col-6">
                           <div class="small-box '.$varColor.'">
                              <div class="inner">
                                <h3>'.number_format($value["total"]).'</h3>
                                <p>kW consumidos año '.$value["anyo"].'</p>
                              </div>
                           <div class="icon">
                           <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
                         </div>
                        </div>';
            $k++;
           }
           

         ?>              
         <?php
	       
        
         $items = ControladorProduccion::ctrMostrarkhwtonDash();
         $datosEstadisticos = array();
      
         
          foreach ($items as $key => $value)
           {
              array_push($datosEstadisticos,array(
                'anyo' => $value["anyo"],
                'mes' => $value["mes"],
                'valor'  => $value["Kwh/TON"]
                      ));
                                 
           
          }
          $result = array();
          foreach ($datosEstadisticos as $element) {
              $result[$element['anyo']][] = $element;
          }
         
          

                 
                        $keys = array_keys($result);
                        $months = array('Ene.','Feb.',  'Mar.', 'Abr.',  'May',  'Jun.',  'Jul.',  'Ago.',  'Sep.',  'Oct.', 'Nov.', 'Dic.');
                        $labels = "";
                        $data = "";
                        $datasets = "";
                        $R = 60;
                        $G = 141;
                        $B = 188;
                        $A = 0.9;
                        for($i = 0; $i < count($result); $i++) {
                         
                                 $data = "";    
                                foreach($result[$keys[$i]] as $key => $value) 
                                  {
                                  
                                      $data.= "'".$value["valor"]."',"; 
                                  
                                  }
                                 $data.=  substr( $data , 0 , -1);
                                 $datasets.= "{";
                                  $datasets.= "label               : 'Año ". $keys[$i] ." KwH/Ton',
                                                backgroundColor     : 'rgba($R,$G,$B,$A)',
                                                borderColor         : 'rgba($R,$G,$B,".floatval($A-0.1).")',
                                                pointRadius          : true,
                                                pointColor          : 'rgba($R,$G,$B,$A)',
                                                pointStrokeColor    : 'rgba($R,$G,$B,".floatval($A+0.1).")',
                                                pointHighlightFill  : '#fff',
                                                pointHighlightStroke: 'rgba($R,$G,$B,".floatval($A+0.1).")',
                                                data                : [".$data."]"; 
                                  $datasets.= "},";
                                  
                                  $R = $R + 150;
                                  $G = $G + 70;
                                  $B = $B + 30;


                               

                            }
                        ?>   
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Datos generales</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="#" class="dropdown-item">Action</a>
                      <a href="#" class="dropdown-item">Another action</a>
                      <a href="#" class="dropdown-item">Something else here</a>
                      <a class="dropdown-divider"></a>
                      <a href="#" class="dropdown-item">Separated link</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-7">
                    <p class="text-center">
                      <strong>KWH/TON (2018 vs 2019)</strong>
                    </p>

                    <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
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
                  $fun="MAX";
                  $items = ControladorProduccion::ctrMostrarProduccionIndicador($fun);
                  $datosEstadisticos_max = array();
                  foreach ($items as $key => $value)
                  {
                      echo '<div class="progress-group">
                          <span class="progress-text">Máx. Indicador energetico a la fecha-> </span>
                          <span class="float-right"><b> '.number_format($value["indicador"], 2, '.', ' ').'</b> Feb 2018</span>
                          <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: '.$value["indicador"].'%"></div>
                          </div>
                       </div>';
                  }
                  ?> 
                  

                    <!-- /.progress-group -->
                  <?php
                  $fun="MIN";
                  $items = ControladorProduccion::ctrMostrarProduccionIndicador($fun);
                  $datosEstadisticos_min = array();
                  foreach ($items as $key => $value)
                  {
                    echo '<div class="progress-group">
                            <span class="progress-text">Min. Indicador energetico a la fecha-> </span>
                            <span class="float-right"><b> '.number_format($value["indicador"], 2, '.', ' ').'</b> Oct. 2019</span>
                            <div class="progress progress-sm">
                              <div class="progress-bar bg-success" style="width: '.$value["indicador"].'%"></div>
                            </div>
                          </div>';
                  }
                  ?>    
                    <!-- /.progress-group -->
                    <div class="progress-group">
                      Send Inquiries
                      <span class="float-right"><b>250</b>/500</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" style="width: 50%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->
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
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                      <h5 class="description-header">$35,210.43</h5>
                      <span class="description-text">TOTAL REVENUE</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                      <h5 class="description-header">$10,390.90</h5>
                      <span class="description-text">TOTAL COST</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                      <h5 class="description-header">$24,813.53</h5>
                      <span class="description-text">TOTAL PROFIT</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block">
                      <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                      <h5 class="description-header">1200</h5>
                      <span class="description-text">GOAL COMPLETIONS</span>
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
    datasets: [ <?php echo $datasets; ?> ]
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

  // This will get the first returned node in the jQuery collection.
  var salesChart = new Chart(salesChartCanvas, { 
      type: 'line', 
      data: salesChartData, 
      options: salesChartOptions
    }
  )
  })


</script>