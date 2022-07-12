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


</style>

<?php
                        if(!isset($_POST["fronteraReporte"]))
                                {
                                    echo '<script>
                                          window.location = "listadoFronteras";
                                          </script>'; 
                                }
                        
                ?> 

  <section class="content">
    <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              
                <div class="row">
                    <div class="col-3">
                      <h3 class="card-title"><button class="btn btn-primary btnAtrasSolicitud" onclick="location.href='listadoFronteras'" data-toggle="modal" >Atras</button></h3>
                    </div>
                    <div class="col-5"></div>
                </div>
          
            
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-striped table-bordered tablas" id="tabla_total_ids"   style="width:100%">
                 <caption>Lista de lecturas x frontera</caption> 
                 <thead>
                  <tr>
                    <th>AÑO</th>
                    <th>MES</th>
                    <th>DIA</th>
                    <th>FRONTERA</th>
                    <th>H1</th>
                    <th>H2</th>
                    <th>H3</th>
                    <th>H4</th>
                    <th>H5</th>
                    <th>H6</th>
                    <th>H7</th>
                    <th>H8</th>
                    <th>H9</th>
                    <th>H10</th>
                    <th>H11</th>
                    <th>H12</th>
                    <th>H13</th>
                    <th>H14</th>
                    <th>H15</th>
                    <th>H16</th>
                    <th>H17</th>
                    <th>H18</th>
                    <th>H19</th>
                    <th>H20</th>
                    <th>H21</th>
                    <th>H22</th>
                    <th>H23</th>
                    <th>H24</th>
                  </tr> 
                </thead>
                  <tbody>
                  <?php
                  
                    $cadenaFecha =$_POST["daterange"];
                    $arrayCadenaFecha = explode("-", $cadenaFecha);
                    $item = "frontera_fronteraCliente";
                    $valor = $_POST["fronteraReporte"];
                    $valor2 = $arrayCadenaFecha[0];
                    $valor21 = $arrayCadenaFecha[1];
                    $item3 = "tipoEnergia";
                    $valor3 =  $_POST["tipoEnergia"];
                    $items = ControladorFronteras::crtMostrarMatrizEnergiaDatos($item, $valor,$valor2,$valor21,$item3,$valor3);
                    foreach ($items as $key => $value)
                    {
                      ?>
                         <tr>
                                  <td><?=$value["anyoLectura"]?></td> 
                                  <td><?=$value["mesLectura"]?></td>
                                  <td><?=$value["diaLectura"]?></td> 
                                  <td><?=$value["frontera_fronteraCliente"]?></td>
                                  <td><?=$value["H1"]?></td>
                                  <td><?=$value["H2"]?></td> 
                                  <td><?=$value["H3"]?></td>
                                  <td><?=$value["H4"]?></td>
                                  <td><?=$value["H5"]?></td> 
                                  <td><?=$value["H6"]?></td> 
                                  <td><?=$value["H7"]?></td>
                                  <td><?=$value["H8"]?></td> 
                                  <td><?=$value["H9"]?></td> 
                                  <td><?=$value["H10"]?></td>
                                  <td><?=$value["H11"]?></td> 
                                  <td><?=$value["H12"]?></td> 
                                  <td><?=$value["H13"]?></td>
                                  <td><?=$value["H14"]?></td> 
                                  <td><?=$value["H15"]?></td> 
                                  <td><?=$value["H16"]?></td>
                                  <td><?=$value["H17"]?></td> 
                                  <td><?=$value["H18"]?></td> 
                                  <td><?=$value["H19"]?></td>
                                  <td><?=$value["H20"]?></td> 
                                  <td><?=$value["H21"]?></td> 
                                  <td><?=$value["H22"]?></td>
                                  <td><?=$value["H23"]?></td> 
                                  <td><?=$value["H24"]?></td> 
                                 
                              </tr>
                   <?php   }  ?> 

                  </tbody>
                 
                </table>
              </div>
            </div>
          </div>
    </div>
  </section>
</div>
