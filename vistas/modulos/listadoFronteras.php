<style>
 td {font-size: 14px;}
 
 th {font-size: 14px;}

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

 td.details-control {
    background: url('vistas/img/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('vistas/img/details_close.png') no-repeat center center;
}
</style>
<?php
	$anyo_curso = date("Y");
  $mes_curso = date("n");
  $dia_curso = date("d");


?>
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Listado de fronteras </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Home</a></li>
              <li class="breadcrumb-item active">Administrar fronteras </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            
            <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped dt-responsive tablas" id="example_table" >
                    <caption>Listado de fronteras</caption>
                <?php
                        if($_SESSION["perfilSesion"] == 9)
                        {
                          $item = NULL;
                          $valor = NULL;
                          $adicion = "<th>SEGUIMIENTO</th><th>CANT. MIN KV</th><th>ACCIONES</th>";

                         
                        }
                        else
                        {
                          $item = "clienteFrontera_nitCliente";
                          $valor = $_SESSION["identificador"];
                          $adicion ="<th>ACCIONES</th>";
                        }  
                ?>
                    <thead>
                     <tr>
                      <th scope="col"></th>
                      <th scope="col">FRONTERA</th>
                      <th scope="col">DESCRIPCION FRONTERA</th>
                      <th scope="col">NIU ITALENER</th>
                      <th scope="col">NIU OPERADOR</th>
                      <?php echo $adicion; ?>
                     </tr> 
                    </thead>
                    <tbody>
                        <?php
                      $items = ControladorFronteras::ctrMostrarFronteras($item, $valor);
                      foreach ($items as $key => $value)
                      {
                      
                       
                            if($_SESSION["perfilSesion"] == 9)
                            {
                              $r = ("S" == $value["seguimiento"]) ? "SI" : "NO"; 
                              echo "<tr> 		                  
                                      <td class='details-control' id='td_".$value["fronteraCliente"]."' vlr='".$value["fronteraCliente"]."'></td>
                                      <td>".$value["fronteraCliente"]."</td> 
                                      <td>".$value["descripcionFrontera"]."</td> 
                                      <td>".$value["niuEmpresa"]."</td> 
                                      <td>".$value["niuOperador"]."</td> 
                                      <td>".$r."</td> 
                                      <td>".$value["minimoKv"]."</td> 
                                      <td>
                                          <div class='btn-group'>
                                            <button class='btn btn-primary px-2.5' onclick=editarFrontera('".$value["fronteraCliente"]."')  data-toggle='modal' data-target='#modalEditarFrontera'><i class='far fa-edit' aria-hidden='true'></i></button>
                                          </div>
                                          <div class='btn-group'>
                                            <button class='btn btn-primary px-2.5' onclick=reporteFrontera('".$value["fronteraCliente"]."')  data-toggle='modal' data-target='#modalGeneraraReporte' title='Generar matriz datos'><i class='fas fa-database' aria-hidden='true'></i></button>
                                          </div>
                                      </td>
                                    </tr>";
                            }
                            else
                            {
                              echo " <tr> 		                  
                                        <td class='details-control' id='td_".$value["fronteraCliente"]."' vlr='".$value["fronteraCliente"]."'></td>
                                        <td>".$value["fronteraCliente"]."</td> 
                                        <td>".$value["descripcionFrontera"]."</td> 
                                        <td>".$value["niuEmpresa"]."</td> 
                                        <td>".$value["niuOperador"]."</td> 
                                        <td>
                                          <div class='btn-group'>
                                            <button class='btn btn-primary px-2.5' onclick=reporteFrontera('".$value["fronteraCliente"]."')  data-toggle='modal' data-target='#modalGeneraraReporte' title='Generar matriz datos'><i class='fas fa-database' aria-hidden='true'></i></button>
                                          </div>
                                        </td>
                                    </tr>";
                            }
                       
                        }


                   ?> 

                    </tbody>
                      <tfoot>
                        <tr>
                        <th></th>
                        <th>FRONTERA</th>
                        <th>DESCRIPCION FRONTERA</th>
                        <th>NIU ITALENER</th>
                        <th>NIU OPERADOR</th>
                        <?php echo $adicion; ?>
                        </tr> 
                      </tfoot>
                </table>
              </div>
        </div>        
      </div>
    </div>
  </section>
</div>


  <!-------------------------------------------------------------------------------------------------------------------->
<!--=====================================
MODAL EDITAR FRONTERA
======================================-->
<div id="modalEditarFrontera" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
          <input type="hidden"  name="editaridentificador" id="editaridentificador">
      <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
       <div class="modal-header" style="background:#3c8dbc; color:white">
         
          <div class="col-4">
              <h4 class="modal-title"><i class="far fa-edit"></i></h4>
          </div>
          <div class="col-4">
              <label>Opciones de la frontera</label>
          </div>
          <div class="col-4">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>        

        </div>
        
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
          
            <!-- ENTRADA PARA EL SEGUMIENTO -->
            <div class="form-group">
              <div class="input-group">
                  <select class="form-control select2" name="seguimientoeditar" id="seguimientoeditar" title="Seguimiento energia penalizada"  required>
                    <option value="" >Seguimiento usuario...</option>
                    <option value="S">SI</option>
                    <option value="N">NO</option>
                  </select>  
              </div>
            </div>
            <!-- ENTRADA PARA EL MINIMO kwh -->
            <div class="form-group">
              <div class="input-group">
                 <input type="text" name="editarminimoKv" id="editarminimoKv" class="form-control" placeholder="Cantidad min Kv para alertar" value="" />
              </div>
            </div>


<!------------------------------------------>

           </div>

        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      <?php

          $editarFrontera = new ControladorFronteras();
          $editarFrontera -> ctrEditarFrontera();
            
        ?> 

      </form>
    </div>
  </div>
</div>
<!--=====================================
MODAL GENERAR MATRIZ DATOS
======================================-->
<div id="modalGeneraraReporte" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" action="datosGenerados">
          <input type="hidden"  name="fronteraReporte" id="fronteraReporte" value="" />
      <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
       <div class="modal-header" style="background:#3c8dbc; color:white">
         
          <div class="col-4">
              <h4 class="modal-title"><i class="far fa-edit"></i></h4>
          </div>
          <div class="col-4">
              <label>Generar matriz de lecturas</label>
          </div>
          <div class="col-4">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>        

        </div>
        
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL SEGUMIENTO -->
            <div class="form-group">
                <label>Fecha:</label>
                    <div class="input-group date"> 
                          <input type="text" class="form-control datetimepicker-input" name="daterange" id="daterange" value="" />
                   </div>
            </div>
            <div class="form-group">
                <label>Tipo energia:</label>
                <div class="input-group">
                    <select class="form-control select2" name="tipoEnergia" id="tipoEnergia" title="Tipo de energia"  required>
                      <option value="A">Activa</option>
                      <option value="R">Reactiva</option>
                      <option value="E">Exportada</option>
                      <option value="P">Penalizada</option>
                      <option value="C">Capacitiva</option>
                    </select>  
                   </div>
            </div>
            <!------------------------------------------>
         </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Generar datos</button>
        </div>
      
      </form>
    </div>
  </div>
</div>
