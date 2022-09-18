<section class="content">
  <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
             
              <div class="row">
                  <div class="col-5">
                  <h3 class="card-title">Listado de desviación</h3>     
                  </div>
               </div>
               <div class="row">   
                <div class="col-4">
                 </div>
                 <div class="col-4" >
                 <?php
                    $item = null;
                    $valor = null;
                    
                    $items = ControladorDesviacion::ctrMostrarDesviacion($item, $valor); 
                    if(count($items) == 0)
                    {
                    ?>  
                      <div class="icon-bar">
                        <a data-toggle="modal" data-target="#modalAgregarDesviacion"  id="iconAddUser"   title="Crear desviacion" href="#"><em class="fas fa-file-invoice"></em></a> 
                      </div>
                     <?php
                      } 
                     ?> 
                 </div> 
                 <div class="col-4">
                 </div> 
                </div> 
           
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive tablas">
              <caption>Listado de desviación</caption>  
              <thead>
                <tr>
                  <th id="idlog">ID</th>
                  <th id="archivo_tag">VLR MAX / VLR MIN</th>
                  <th id="date_tag">FECHA CREACION</th>
                  <th id="date_tag">FECHA ACTUALIZACIÓN</th>
                  <th id="opciones_tag">OPCIONES</th>
                </tr> 
                </thead>
                <tbody>
                <?php
                $item = null;
                $valor = null;
                
                $items = ControladorDesviacion::ctrMostrarDesviacion($item, $valor); 
                foreach ($items as $key => $value){
                      ?>
                           <tr>
                                    <td><?= $value["iddesviacion"] ?> </td>
                                    <td><?= $value["vlrMaximo"].'/'.$value["vlrMinimo"] ?></td>
                                    <td><?= $value["fechaRegistro"] ?></td>
                                    <td><?= $value["fechaUpdate"] ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-primary px-2.5" onclick=editDataDesviacion(<?= $value["iddesviacion"] ?>)  data-toggle="modal" data-target="#modalEditDesviacion"><em class="far fa-edit"></em></button>
                                       </div> 
                                    </td>
                                </tr>
                   <?php } ?> 
                </tbody>
                <tfoot>
                <tr>
                  <th id="idlog">ID</th>
                  <th id="archivo_tag">VLR MAX / VLR MIN</th>
                  <th id="date_tag">FECHA CREACION</th>
                  <th id="date_tag">FECHA ACTUALIZACIÓN</th>
                  <th id="opciones_tag">OPCIONES</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
  </div>
  </section>
</div>

<!--=====================================
MODAL AGREGAR DESVIACION
======================================-->
<div id="modalAgregarDesviacion" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form aria-label="Formulario de ingreso de desviaciones" role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
         
                  <div class="col-4">
                      <h4 class="modal-title"><em class="fas fa-user-plus" ></em></h4>
                  </div>
                  <div class="col-4">
                     <label>Agregar desviacion</label>
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
           <!-- ENTRADA PARA EL VLR MINIMO -->
            <div class="form-group">
              <div class="input-group">
                  <input type="number" class="form-control" name="vlr_Minimo" id="vlr_Minimo" placeholder="Valor minimo" min="1" max="100" required>
              </div>
            </div>
          <!-- ENTRADA PARA EL VLR MAXIMO -->
            <div class="form-group">
              <div class="input-group">
                  <input type="number" class="form-control" name="vlr_Maximo" id="vlr_Maximo" placeholder="Valor maximo" min="1" max="100" required>
              </div>
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar item</button>
        </div>
        <?php
          $crearDesviacion = new ControladorDesviacion();
          $crearDesviacion -> ctrCrearDesviacion();
        ?>
      </form>
    </div>
  </div>
</div> 

<!--=====================================
MODAL AGREGAR DESVIACION
======================================-->
<div id="modalEditDesviacion" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form aria-label="Formulario de edicion de desviacion" role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
         
                  <div class="col-4">
                      <h4 class="modal-title"><em class="fas fa-user-plus" ></em></h4>
                  </div>
                  <div class="col-4">
                     <label>Editar desviacion</label>
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
           <!-- ENTRADA PARA EL VLR MINIMO -->
            <div class="form-group">
              <div class="input-group">
                  <input type="number" class="form-control" name="vlrMinimo" id="vlrMinimo" placeholder="Valor minimo" min="1" max="100" required>
              </div>
            </div>
          <!-- ENTRADA PARA EL VLR MAXIMO -->
            <div class="form-group">
              <div class="input-group">
                  <input type="number" class="form-control" name="vlrMaximo" id="vlrMaximo" placeholder="Valor maximo" min="1" max="100" required>
              </div>
            </div>
          </div>
        </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar item</button>
        </div>
        <?php
          $editarDesviacion = new ControladorDesviacion();
          $editarDesviacion -> ctrEditDesviacion();
        ?>
        <input type="hidden" id="iddesviacion" name="iddesviacion" value=""/>
      </form>
    </div>
  </div>
</div> 

<form method="post" name="form_editMenu" id="form_editMenu" action="editMenu">    
    <input id="identificadorMenu" name="identificadorMenu" type="hidden" value="" />
</form>