<style>
 td {font-size: 14px;}
 
 th {font-size: 14px;}

 .icon-bar {
  width: 100%;
  background-color: #ffffff; 
  overflow: auto;
  border-style: dashed;
}

.icon-bar a {
  float: left;
  width: 20%;
  text-align: center;
  /*padding: 12px 0;*/
  transition: all 0.3s ease;
  color: #1187ff;
  font-size: 35px;
  background-color: #ffffff;
 
}

/* Ensure that the demo table scrolls */
th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }

</style>

<?php
                        if(!isset($_POST["proyecto_id_grafica"]))
                                {
                                    echo '<script>
                                          window.location = "proyectos";
                                          </script>'; 
                                }
                          else
                                {       
                                    $item = "proyecto_idproyecto";
                                    $valor = $_POST["proyecto_id_grafica"];
                                    $item1 = "p.proyecto_idproyecto";
                                    $item2 = "fuenteEnergia_idfuenteEnergia";
                                    $valor1 = $_POST["proyecto_id_grafica"];
                                    $valor2 = $_POST["fuenteEnergia_id_grafica"];
                                    $relacion="";
                                    $unidadM = "";
                                    $valueTabla ="";
                                    $items = ControladorProduccion::ctrMostrarProduccionGraficas($item1,$item2, $valor1,$valor2);
                                    $datosEstadisticos = array();
                                    $datosEstadisticos_toneladas = array();
                                    $datosEstadisticos_kwh = array();  
                                    
                                     foreach ($items as $key => $value)
                                      {
                         
                                        $relacion = $value["unidadMedidaFuente"]."/Ton";
                                        $unidadM=$value["unidadMedidaFuente"];  
                                        array_push($datosEstadisticos,array(
                                           'anyo' => $value["anyo"],
                                           'mes' => $value["mes"],
                                           'valor'  => $value["indicador"]
                                                 ));
                                         array_push($datosEstadisticos_toneladas,array(
                                                   'anyo' => $value["anyo"],
                                                   'mes' => $value["mes"],
                                                   'valor'  => $value["toneladas"]
                                                         ));
                                        array_push($datosEstadisticos_kwh,array(
                                                          'anyo' => $value["anyo"],
                                                          'mes' => $value["mes"],
                                                          'valor'  => $value["consumo"]
                                                                ));                
                                                         
                                        $valueTabla.= ' <tr>
                                                     <td>'.$value["anyo"].'</td> 
                                                     <td>'.$value["mes"].'</td>
                                                     <td>'.$value["consumo"].'</td>
                                                     <td>'.$value["costo"].'</td>
                                                     <td>'.$value["toneladas"].'</td>
                                                     <td>'.$value["indicador"].'</td> 
                                                     <td>'.$value["nombrePlanta"].'</td> 
                                                 </tr>';
                                      }
                                     $result = array();
                                     foreach ($datosEstadisticos as $element) 
                                     {
                                         $result[$element['anyo']][] = $element;
                                     }
                                     $result_ton = array();
                                     foreach ($datosEstadisticos_toneladas as $element)
                                     {
                                         $result_ton[$element['anyo']][] = $element;
                                     }
                                     $result_kwh = array();
                                     foreach ($datosEstadisticos_kwh as $element)
                                     {
                                         $result_kwh[$element['anyo']][] = $element;
                                     }
                                }

                               
                ?> 
<div class="content-wrapper">
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>GRAFICAS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Home</a></li>
              <li class="breadcrumb-item active">INFORMACIÓN</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  </section>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------------->

  <section class="content">
  <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
             
              <div class="row">
                  <div class="col-3">
                    <h3 class="card-title"><button class="btn btn-primary btnAtrasSolicitud" onclick="location.href='proyectos'" data-toggle="modal" data-target="#modalAgregarPlantillaTrabajo">Atras</button></h3>
                  </div>
                  <div class="col-5">
                          <div class="text-center" >
                            <b>RELACION <?php echo $relacion; ?></b>
                          </div>
                  </div>
               </div>
        
           
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped tablas" id="tabla_total_kwhton"  style="width:100%">
                <thead>
                <tr>
                  <th>AÑO</th>
                  <th>MES</th>
                  <th><?php echo $value["unidadMedidaFuente"]; ?> CONSUMIDOS</th>
                  <th>COSTO</th>
                  <th>TON.PRODUCIDAS</th>
                  <th><?php echo $relacion; ?></th>
                  <th>PLANTA</th>
                </tr> 
              </thead>
        <tbody>
        <?php
	       
           echo $valueTabla;
         
		        

        ?> 
       </tbody>
      </table>
      </div>

    </div>
  </section>
  <section>
     <div class="container-fluid">
        <div class="row">
          
                <div class="col-md-6">
                    <!-- AREA CHART -->
                    <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">Gráfico de area - Eficiencia <?php echo $value["nombreFuente"];?></h3>

                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="chart">
                          <canvas id="areaChart" style="height:250px; min-height:250px"></canvas>
                        </div>
                      </div>
                    </div>
                </div>
          <!-- /.col (LEFT) -->
                  <div class="col-md-6">
                  <!-- BAR CHART -->
                    <div class="card card-success">
                      <div class="card-header">
                        <h3 class="card-title">Gráfico de barras -  Eficiencia <?php echo $value["nombreFuente"];?>
                        <?php
                        
                          $keys = array_keys($result);
                          $months = array('Ene.','Feb.',  'Mar.', 'Abr.',  'May',  'Jun.',  'Jul.',  'Ago.',  'Sep.',  'Oct.', 'Nov.', 'Dic.');
                          $labels = "";
                          $data = "";
                          $datasets = "";
                          $R = 60;
                          $G = 141;
                          $B = 188;
                          $A = 0.9;
                          $datafills_php="";
                          for($i = 0; $i < count($result); $i++) {
                           
                                   $data = "";
                                  foreach($result[$keys[$i]] as $key => $value) 
                                    {
                                       
                                        $data.= "'".$value["valor"]."',"; 
                                       
                                    
                                    }
                                   $data =  substr( $data , 0 , -1);
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
                                    
                                    $R = $R + 80;
                                    $G = $G + 20;
                                    $B = $B + 5;

                                  

                                    $datafills_php.="lineChartData.datasets[".$i."].fill = false;";
                                 

                              }
                          ?>   
                        </h3>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="chart">
                          <canvas id="barChart" style="height:230px; min-height:230px"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
        </div>
      </div><!-- /.container-fluid -->
  </section>
<!------------------------------------------------------------------------------------------------------------------------------------------------------------------->

  <section>
     <div class="container-fluid">
        <div class="row">
          
                <div class="col-md-6">
                    <!-- AREA CHART -->
                    <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">Gráfico de area - Toneladas producidas</h3>

                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="chart">
                          <canvas id="areaChart_ton" style="height:250px; min-height:250px"></canvas>
                        </div>
                      </div>
                    </div>
                </div>
          <!-- /.col (LEFT) -->
                  <div class="col-md-6">
                  <!-- BAR CHART -->
                    <div class="card card-success">
                      <div class="card-header">
                        <h3 class="card-title">Gráfico de barras - Toneladas producidas</h3>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="chart">
                          <canvas id="barChart_ton" style="height:230px; min-height:230px"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
        </div>
      </div><!-- /.container-fluid -->
  </section>  
<!------------------------------------------------------------------------------------------------------------------------------------------------------------------->

<section>
     <div class="container-fluid">
        <div class="row">
          
                <div class="col-md-6">
                    <!-- AREA CHART -->
                    <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">Gráfico de area - <?php echo $unidadM; ?> consumidos</h3>

                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="chart">
                          <canvas id="areaChart_kwh" style="height:250px; min-height:250px"></canvas>
                        </div>
                      </div>
                    </div>
                </div>
          <!-- /.col (LEFT) -->
                  <div class="col-md-6">
                  <!-- BAR CHART -->
                    <div class="card card-success">
                      <div class="card-header">
                        <h3 class="card-title">Gráfico de barras -  <?php echo $unidadM; ?> consumidos</h3>
                        <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="chart">
                          <canvas id="barChart_kwh" style="height:230px; min-height:230px"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
        </div>
      </div><!-- /.container-fluid -->
  </section>
</div>
<?php
                        
                        $keys_ton = array_keys($result_ton);
                        $keys_kwh = array_keys($result_kwh);

                        $months = array('Ene.','Feb.',  'Mar.', 'Abr.',  'May',  'Jun.',  'Jul.',  'Ago.',  'Sep.',  'Oct.', 'Nov.', 'Dic.');
                        $labels_ton = "";
                        $labels_kwh = "";
                        $data_ton = "";
                        $data_kwh = "";
                        $datasets_ton = "";
                        $datasets_kwh = "";
                        $R_ton = 60;
                        $G_ton = 141;
                        $B_ton = 188;
                        $A_ton = 0.9;
                        $R_kwh = 60;
                        $G_kwh = 141;
                        $B_kwh = 188;
                        $A_kwh = 0.9;
                        $datafills_php_ton="";
                        for($j = 0; $j < count($result_ton); $j++)
                           {
                         
                                 $data_ton = "";    
                                foreach($result_ton[$keys_ton[$j]] as $key => $value) 
                                  {
                                  
                                      $data_ton.= "'".$value["valor"]."',"; 
                                  
                                  }
                                 $data_ton =  substr( $data_ton , 0 , -1);
                                 $datasets_ton.= "{";
                                  $datasets_ton.= "label               : 'Año ". $keys_ton[$j] ." Ton',
                                                backgroundColor     : 'rgba($R_ton,$G_ton,$B_ton,$A_ton)',
                                                borderColor         : 'rgba($R_ton,$G_ton,$B_ton,".floatval($A_ton-0.1).")',
                                                pointRadius          : true,
                                                pointColor          : 'rgba($R_ton,$G_ton,$B_ton,$A_ton)',
                                                pointStrokeColor    : 'rgba($R_ton,$G_ton,$B_ton,".floatval($A_ton+0.1).")',
                                                pointHighlightFill  : '#fff',
                                                pointHighlightStroke: 'rgba($R_ton,$G_ton,$B_ton,".floatval($A_ton+0.1).")',
                                                data                : [".$data_ton."]"; 
                                  $datasets_ton.= "},";
                                  
                                  $R_ton = $R_ton + 80;
                                  $G_ton = $G_ton + 20;
                                  $B_ton = $B_ton + 5;

                                  $datafills_php_ton.="lineChartData_ton.datasets[".$j."].fill = false;"; 
                               

                            }
                            $datafills_php_kwh="";
                            for($j = 0; $j < count($result_kwh); $j++)
                            {
                          
                                  $data_kwh = "";    
                                 foreach($result_kwh[$keys_kwh[$j]] as $key => $value) 
                                   {
                                   
                                       $data_kwh.= "'".$value["valor"]."',"; 
                                   
                                   }
                                  $data_kwh =  substr( $data_kwh , 0 , -1);
                                  $datasets_kwh.= "{";
                                   $datasets_kwh.= "label               : 'Año ". $keys_kwh[$j] ." KhW',
                                                 backgroundColor     : 'rgba($R_kwh,$G_kwh,$B_kwh,$A_kwh)',
                                                 borderColor         : 'rgba($R_kwh,$G_kwh,$B_kwh,".floatval($A_kwh-0.1).")',
                                                 pointRadius          : true,
                                                 pointColor          : 'rgba($R_kwh,$G_kwh,$B_kwh,$A_kwh)',
                                                 pointStrokeColor    : 'rgba($R_kwh,$G_kwh,$B_kwh,".floatval($A_kwh+0.1).")',
                                                 pointHighlightFill  : '#fff',
                                                 pointHighlightStroke: 'rgba($R_kwh,$G_kwh,$B_kwh,".floatval($A_kwh+0.1).")',
                                                 data                : [".$data_kwh."]"; 
                                   $datasets_kwh.= "},";
                                   
                                   $R_kwh = $R_kwh + 80;
                                   $G_kwh = $G_kwh + 20;
                                   $B_kwh = $B_kwh + 5;
 
                                   $datafills_php_kwh.="lineChartData_kwh.datasets[".$j."].fill = false;"; 
                                
 
                             }
                        ?>   
    
<script>
  $(function () {
   
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    var areaChartCanvas_ton = $('#areaChart_ton').get(0).getContext('2d')
    var areaChartCanvas_kwh = $('#areaChart_kwh').get(0).getContext('2d')

    var areaChartData = 
    {
          labels  : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
          datasets: [ <?php echo $datasets; ?> ]
    }

    var areaChartData_ton = 
    {
          labels : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
          datasets: [ <?php echo $datasets_ton; ?> ]
    }

    var areaChartData_kwh = 
    {
          labels : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
          datasets: [ <?php echo $datasets_kwh; ?> ]
    }
    var areaChartOptions = {
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
  
    var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
    var lineChartData = jQuery.extend(true, {}, areaChartData)
   <?php 
         echo $datafills_php;
     ?>
    lineChartOptions.datasetFill = false

    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'line',
      data: lineChartData, 
      options: lineChartOptions
    })
//-----------------------------------------------------------------------------------------------------------//
    var lineChartOptions_ton = jQuery.extend(true, {}, areaChartOptions)
    var lineChartData_ton = jQuery.extend(true, {}, areaChartData_ton)
   <?php 
         echo $datafills_php_ton;
     ?>
    lineChartOptions_ton.datasetFill = false
    var areaChart_ton       = new Chart(areaChartCanvas_ton, { 
      type: 'line',
      data: lineChartData_ton, 
      options: lineChartOptions_ton
    })

//-----------------------------------------------------------------------------------------------------------//
var lineChartOptions_kwh = jQuery.extend(true, {}, areaChartOptions)
    var lineChartData_kwh = jQuery.extend(true, {}, areaChartData_kwh)
   <?php 
         echo $datafills_php_kwh;
     ?>
    lineChartOptions_kwh.datasetFill = false
    var areaChart_kwh       = new Chart(areaChartCanvas_kwh, { 
      type: 'line',
      data: lineChartData_kwh, 
      options: lineChartOptions_kwh
    })
   

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
   
    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      data: barChartData,
      options: barChartOptions
    })

    //-------------
    //- BAR CHART TON -
    //-------------
    var barChartCanvas_ton = $('#barChart_ton').get(0).getContext('2d')
    var barChartData_ton = jQuery.extend(true, {}, areaChartData_ton)
    

    var barChartOptions_ton = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart_ton = new Chart(barChartCanvas_ton, {
      type: 'bar', 
      data: barChartData_ton,
      options: barChartOptions_ton
    })

  //-------------
    //- BAR CHART KWH -
    //-------------
    var barChartCanvas_kwh = $('#barChart_kwh').get(0).getContext('2d')
    var barChartData_kwh = jQuery.extend(true, {}, areaChartData_kwh)
    

    var barChartOptions_kwh = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart_kwh = new Chart(barChartCanvas_kwh, {
      type: 'bar', 
      data: barChartData_kwh,
      options: barChartOptions_kwh
    }) 
    
  })
</script>