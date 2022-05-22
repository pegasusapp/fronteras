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
                        if(!isset($_POST["proyecto_id"]))
                                {
                                    echo '<script>
                                          window.location = "proyectos";
                                          </script>'; 
                                }
                          else
                                {
                                    $item = "proyecto_idproyecto";
                                    $valor = $_POST["proyecto_id"];
                                   // $items = ControladorSolicitud::ctrMostrarSolicitudProyeccion($item, $valor);
                                    //$solicitud_sesion=$items["nro_solicitud"];
                                }
                ?> 
<div class="content-wrapper">
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Listado de consumos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Home</a></li>
              <li class="breadcrumb-item active">Administrar consumos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              
                <div class="row">
                    <div class="col-3">
                      <h3 class="card-title"><button class="btn btn-primary btnAtrasSolicitud" onclick="location.href='proyectos'" data-toggle="modal" data-target="#modalAgregarPlantillaTrabajo">Atras</button></h3>
                    </div>
                    <div class="col-5"></div>
                </div>
         
            
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-striped table-bordered tablas" id="tabla_total_ids"  style="width:100%">
                  <thead>
                  <tr>
                    <th>AÑO</th>
                    <th>MES</th>
                    <th>CONSUMO</th>
                    <th>COSTO</th>
                    <th>INDICADOR</th>
                    <th>FUENTE ENERGÍA</th>
                    <th>PLANTA</th>
                    <th>OPCIÓN</th>
                  </tr> 
                </thead>
                  <tbody>
                  <?php
                  
                    $item1 = "tc.proyecto_idproyecto";
                    $valor1 = $_POST["proyecto_id"];
                    $item2 = "tc.fuenteEnergia_idfuenteEnergia";
                    $valor2 = $_POST["fuente_energia_id"];
                    $orden = "anyo";
                    $items = ControladorTotales::ctrMostrarTotales($item1, $valor1,$item2,$valor2,$orden);
                    foreach ($items as $key => $value)
                    {
                      
                        echo ' <tr>
                                  <td>'.$value["anyo"].'</td> 
                                  <td>'.$value["mes"].'</td>
                                  <td>'.$value["consumo"].'</td> 
                                  <td>'.$value["costo"].'</td>
                                  <td>'.$value["indicador"].'</td>
                                  <td>'.$value["nombreFuente"].'</td> 
                                  <td>'.$value["nombrePlanta"].'</td> 
                                  <td>
                                    <div class="btn-group">
                                      <button class="btn btn-warning btnEditarAreas" onclick=editTotales("'.$value["idtotalesConsumo"].'")    data-toggle="modal" data-target="#modalEditarFuente"><i class="far fa-edit"></i></button>
                                    </div>  
                                  </td>
                              </tr>';
                      }


                  ?> 

                  </tbody>
                  <tfoot>
                      <tr>
                        <th colspan="2" style="text-align:right">Total Kw:</th>
                        <th></th>
                        <th colspan="2" style="text-align:right">Total $:</th>
                        <th></th>
                        <th></th>
                     </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
    </div>
  </section>
</div>

<!--=====================================
MODAL EDITAR TOTAL
======================================-->

<div id="modalEditarFuente" class="modal fade" role="dialog">
  <div class="modal-dialog">
   <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
         
                  <div class="col-2">
                      <h4 class="modal-title"><i class="fas fa-location-arrow" ></i></h4>
                  </div>
                  <div class="col-8">
                     <label id="lbl_proyecto_anuncio">Editar datos </label>
                  </div>
                  <div class="col-2">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>        
      
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
            <!-- ENTRADA PARA EL CONSUMO -->
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control input-lg"  name="consumoE" id="consumoE" placeholder="Consumo" required>
              </div>
            </div>
           <!-- ENTRADA PARA EL COSTO -->
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="costoE" id="costoE" placeholder="Costo" required>
              </div>
            </div>
            <!-- ENTRADA PARA EL INDICADOR -->
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="indicadorE" id="indicadorE" placeholder="Indicador" required>
              </div>
            </div>
           <!-- 
             Variables ocultas -->
             <input type="hidden"  name="idtotalesConsumoE" id="idtotalesConsumoE" value="" />               
             <input type="hidden"  name="proyecto_id" id="proyecto_id" value="<?php echo $_POST["proyecto_id"]; ?>" /> 
          </div>
       </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="button" class="btn btn-primary" onClick="saveChangesEdit()">Guardar cambios</button>

        </div>

      <?php

         

          $paginaNiveles =  $_SERVER["REQUEST_URI"];
          $paginaSesion = explode("/", $paginaNiveles);
          $valor = $paginaSesion[2];
          $items = ControladorMenu::ctrMostrarMenuExpandido($valor);
          foreach ($items as $key => $value)
          {
            echo "<script>
            document.getElementById('servicio_".$value["idServicio"]."').className = 'nav-item has-treeview menu-close menu-open';
            document.getElementById('proceso_".$value["idProceso"]."').className = 'nav-item has-treeview menu-close menu-open';
            document.getElementById('subproceso_".$value["idSubproceso"]."').className ='far fa-circle nav-icon text-danger';
                  </script>";
          }

        ?> 

      </form>

    </div>

  </div>
  <form role="form" method="post" id ="sub_rta" name="sub_rta">
  <input type="hidden"  name="proyecto_id" id="proyecto_id" value="<?php echo $_POST["proyecto_id"]; ?>" /> 
  <input type="hidden"  name="fuente_energia_id" id="fuente_energia_id" value="<?php echo $_POST["fuente_energia_id"]; ?>" />
  </form>
</div>
