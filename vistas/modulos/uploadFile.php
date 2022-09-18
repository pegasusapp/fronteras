<section class="content">
  <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
             
              <div class="row">
                  <div class="col-5">
                  <h3 class="card-title">Listado de facturas</h3>     
                  </div>
               </div>
               <div class="row">   
                <div class="col-4">
                 </div>
                 <div class="col-4" >
                      <div class="icon-bar">
                        <a data-toggle="modal" data-target="#modalAgregarFactura"  id="iconAddUser"   title="Crear factura" href="#"><em class="fas fa-file-invoice"></em></a> 
                      </div>
                 </div> 
                 <div class="col-4">
                 </div> 
                </div> 
           
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive tablas">
              <caption>Listado de facturas de energia</caption>  
              <thead>
                <tr>
                  <th id="anyo_tag">AÑO</th>
                  <th id="mes_tag">MES</th>
                  <th id="frontera_tag">FRONTERA</th>
                  <th id="opciones_tag">OPCIONES</th>
                </tr> 
                </thead>
                <tbody>
                <?php
                $item = null;
                $valor = null;
                $items = ControladorFactura::ctrMostrarFactura($item, $valor); 
                foreach ($items as $key => $value):?>
                                  <tr>
                                    <td><?=$value["anyo"]?></td>
                                    <td><?=ControladorValidaciones::monthSelect($value["mes"])?></td> 
                                    <td>
                                      <a href='/docs/facturas/<?=$value["frontera_fronteraCliente"]?>/<?=$value["anyo"].$value["mes"]?>/<?=$value["nameFile"]?>' target="_blank"><?=$value["frontera_fronteraCliente"]?></a>
                                    </td> 
                                    <td>
                                        <div class="btn-group">
                                          <button class="btn btn-primary px-2.5" onclick=borrarFactura("<?=$value["anyo"]?>","<?=$value["mes"]?>","<?=$value["frontera_fronteraCliente"]?>","<?=$value["nameFile"]?>")  data-toggle="modal">
                                            <em class="fas fa-trash-alt"></em>
                                          </button>
                                        </div> 
                                     </td>
                                </tr>
                <?php endforeach;?>                
                </tbody>
                <tfoot>
                <tr>
                  <th id="anyo_tag">AÑO</th>
                  <th id="mes_tag">MES</th>
                  <th id="frontera_tag">FRONTERA</th>
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
MODAL AGREGAR FACTURA
======================================-->
<div id="modalAgregarFactura" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form aria-label="Formulario de ingreso de facturas" role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
         
                  <div class="col-4">
                      <h4 class="modal-title"><em class="fas fa-user-plus" ></em></h4>
                  </div>
                  <div class="col-4">
                     <label>Agregar factura</label>
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
            <!-- ENTRADA PARA EL AÑO -->
            <div class="form-group">
              <div class="input-group">
                  <select class="form-control select2" id="anyoFactura" name="anyoFactura" title="Seleccione el año" required >
                        <option value="">Seleccione el año</option>
                        <?php
                            $yearActual= Date('Y' ); 
                            for($i=2022;$i<=$yearActual+5;$i++)
                            {
                              echo "<option value='".$i."'>".$i."</option>";
                            }
                        ?>
                  </select>     
              </div>
            </div>
           <!-- ENTRADA PARA EL MES -->
            <div class="form-group">
              <div class="input-group">
                    <select class="form-control select2" id="mesFactura" name="mesFactura" title="Seleccione el mes" required >
                      <option value="" >Seleccione el mes</option>
                      <option value="1">Enero</option>
                      <option value="2">Febrero</option>
                      <option value="3">Marzo</option>
                      <option value="4">Abril</option>
                      <option value="5">Mayo</option>
                      <option value="6">Junio</option>
                      <option value="7">Julio</option>
                      <option value="8">Agosto</option>
                      <option value="9">Septiembre</option>
                      <option value="10">Octubre</option>
                      <option value="11">Noviembre</option>
                      <option value="12">Diciembre</option>
                    </select>
              </div>
            </div>
              <!-- ENTRADA PARA EL ARCHIVO -->
            <div class="form-group">
              <div class="input-group">
                  <input type="file" class="form-control" name="nameFile" id="nameFile" placeholder="Ingresar archivo" required>
              </div>
            </div>
             <!-- ENTRADA PARA LA FRONTERA -->
             <div class="form-group">
               <div class="input-group">
                      <select class="form-control select2" id="idFrontera"  name="idFrontera" title="Frontera usuario" required>
                        <option value="" >Seleccione la frontera...</option>
                         <?php

                              $item  = null;
                              $valor = null;
                              $items = ControladorFronteras::ctrMostrarFronteras($item, $valor);
                              foreach ($items as $key => $value)
                                 {
                                   echo '<option value="'.$value["fronteraCliente"].'">'.$value["fronteraCliente"].'  </option>';
                                 }
                          ?> 
                      </select>
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
          $crearFactura = new ControladorFactura();
          $crearFactura -> ctrCrearFactura();
        ?>
      </form>
    </div>
  </div>
</div> 

<form method="post" name="form_editMenu" id="form_editMenu" action="editMenu">    
    <input id="identificadorMenu" name="identificadorMenu" type="hidden" value="" />
</form>