  <section class="content">
  <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
             
              <div class="row">
                  <div class="col-5">
                  <h3 class="card-title">Listado de clientes</h3>     
                  </div>
               </div>
               <div class="row">   
                 
                <div class="col-4">
                 </div>
                 <div class="col-4" >
                    
                 </div> 
                 <div class="col-4">
                 </div> 
                </div> 
           
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive tablas">
                <thead>
                <tr>
                  <th>NIT</th>
                  <th>NOMBRE EMPRESA</th>
                  <th>CONTACTO</th>
                  <th>EMAIL</th>
                  <th>EDITAR</th>
                </tr> 
                </thead>
                <tbody>
                <?php
                $item = null;
                $valor = null;
                $items = ControladorClientesFrontera::ctrMostrarClientesFrontera($item, $valor); 
                foreach ($items as $key => $value)
                    {
                        $r = ('1' == $value["activo"]) ? 'SI' : 'NO'; 
                        echo ' <tr>
                                    <td>'.$value["nitCliente"].'</td>
                                    <td>'.$value["nombreCliente"].'</td> 
                                    <td>'.$value["contactoCliente"].'</td>
                                    <td>'.$value["emailCliente"].'</td>
                                    <td>
                                        <div class="btn-group">
                                          <button class="btn btn-primary px-2.5" onclick=editarCliente("'.$value["nitCliente"].'")  data-toggle="modal" data-target="#modalEditarCliente"><i class="far fa-edit" aria-hidden="true"></i></button>
                                        </div> 
                                    </td>
                                </tr>';
                    }
                ?> 
                </tbody>
                <tfoot>
                <tr>
                  <th>NIT</th>
                  <th>NOMBRE EMPRESA</th>
                  <th>CONTACTO</th>
                  <th>EMAIL</th>
                 <!-- <th>ACTIVO</th>-->
                  <th>EDITAR</th>
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
      <!-- /.row -->
    </section>
</div>

  <!-------------------------------------------------------------------------------------------------------------------->
<!--=====================================
MODAL EDITAR CLIENTE
======================================-->
<div id="modalEditarCliente" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
          <input type="hidden"  name="editarnitCliente" id="editarnitCliente">
          <input type="hidden"  name="editaractivo" id="editaractivo" value="1" />

      <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
       <div class="modal-header" style="background:#3c8dbc; color:white">
         
          <div class="col-4">
              <h4 class="modal-title"><i class="far fa-edit"></i></h4>
          </div>
          <div class="col-4">
              <label>Edición de clientes</label>
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
                <!-- ENTRADA PARA EL CONTACTO -->
                <div class="form-group">
                  <div class="input-group">
                      <input type="text" name="editarcontactoCliente" id="editarcontactoCliente" placeholder="contacto cliente" class="form-control" value="" />
                  </div>
                </div>
                <!-- ENTRADA PARA EL EMAIL -->
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" name="editaremailCliente" id="editaremailCliente" class="form-control" placeholder="email cliente" value="" />
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

          $editarCliente = new ControladorClientesFrontera();
          $editarCliente -> ctrEditarUsuariosFrontera();
            
        ?> 

      </form>
    </div>
  </div>
</div>
