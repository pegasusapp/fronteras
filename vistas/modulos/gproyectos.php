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

 td.details-control {
    background: url('vistas/img/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('vistas/img/details_close.png') no-repeat center center;
}

.floatedTable {
            float:left;
           
        }
.inlineTable {
            display: inline-block;
        
        }
table.floatedTable tbody tr td  { font-size: 11px; }
table.inlineTable tbody tr td  { font-size: 11px; }

</style>
<div class="content-wrapper">
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Listado de proyectos</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="inicio">Home</a></li>
                  <li class="breadcrumb-item active">Administrar proyectos</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                        <div class="col-4" >
                            <a class="btn btn-app" data-toggle="modal" data-target="#modalAgregarCliente"  title="Crear planta" href="#">
                                <i class="fas fa-user-plus"></i> Nuevo cliente
                            </a>
                        </div> 
                </div>
                <div class="row">         
                        <div class="col-md-12">
                            <div class="card card-warning" name="ancla" id="ancla">
                                <div class="card-header">
                                  <h3 class="card-title" >Creación del proyecto</h3>
                                </div>
                      
                                <form role="form" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Tipo de proyecto</label>
                                                      <select id="tipoproyecto_idtipoproyecto" name="tipoproyecto_idtipoproyecto" class="form-control" onchange="changeLbl(this.value)" required >
                                                      <!-- ajax va aqui -->
                                                      </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Nombre del proyecto</label>
                                                    <input type="text" id="nombregProyecto" name="nombregProyecto" class="form-control" placeholder="Enter ..." required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Cliente</label>
                                                    <select id="clienteProyecto_idclienteProyecto" name="clienteProyecto_idclienteProyecto" class="form-control" required >
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">  
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                  <label id="pogsis_lbl">Potencia del sistema (kWp)</label>
                                                  <input type="number" id="potenciagSistema" name="potenciagSistema" class="form-control" step="any" placeholder="Enter ..." required />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                  <label>Generación anual del proyecto (KWh)</label>
                                                  <input type="number" id="generacionaProyecto" name="generacionaProyecto" class="form-control" step="any" placeholder="Enter ..." required />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                  <label>Energia de autoconsumo</label>
                                                  <input type="number" id="energiaAutoconsumo" name="energiaAutoconsumo" class="form-control" step="any" placeholder="Enter ..." required />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                  <label>Energia de excedentes</label>
                                                  <input type="number" id="energiaExcedentes" name="energiaExcedentes" class="form-control" step="any" placeholder="Enter ..." required />
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="row">  
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                  <label>Tarifa de energía aplicada</label>
                                                  <input type="number" id="tarifaAplicada" name="tarifaAplicada" class="form-control" step="any" placeholder="Enter ..." value ="0" />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                              <div class="form-group">
                                                <label>Tarifa de energia generada</label>
                                                <input type="number" id="tarifaGenerada" name="tarifaGenerada" class="form-control" step="any" placeholder="Enter ..."  value ="0" />
                                              </div>
                                          </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                  <label>TRM (COP/USD)</label>
                                                  <input type="number" id="trmDolar" name="trmDolar" class="form-control" step="any" placeholder="Enter ..." required />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                  <label>Impuesto de renta</label>
                                                  <input type="number" id="impuestoRenta" name="impuestoRenta" class="form-control" step="any" placeholder="Enter ..." required />
                                                </div>
                                            </div>
                                          
                                        </div>  
                                        <div class="row"> 
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                  <label>Depreciación (Años)</label>
                                                  <input type="number" id="depreciacion" name="depreciacion" class="form-control" step="any" placeholder="Enter ..." required />
                                                </div>
                                            </div> 
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                  <label>IPC (%)</label>
                                                  <input type="number" id="ipc" name="ipc" class="form-control" step="any" placeholder="Enter ..." required />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                              <div class="form-group">
                                                <label>DTF(%)</label>
                                                <input type="number" id="dtf" name="dtf" class="form-control" step="any" placeholder="Enter ..." required />
                                              </div>
                                            </div>
                                            <div class="col-sm-3">
                                              <div class="form-group">
                                                  <label>Interés Bancario (E/A)</label>
                                                  <input type="number" id="interesBancario" name="interesBancario" class="form-control" step="any" placeholder="Enter ..." required />
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-sm-12">
                                              <div class="form-group">
                                                <label>Descripción</label>
                                                <textarea class="form-control" id="descripcionProyecto" name="descripcionProyecto" rows="3" placeholder="Enter ..."></textarea>
                                              </div>
                                            </div>
                                        </div>
                                      </div>
                                      <input type="hidden" name="idgproyecto" id="idgproyecto" value="" /> 
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                                          <button type="submit" class="btn btn-primary">Guardar item</button>
                                      </div> 
                                    <?php
                                        $creargProyecto = new ControladorgProyecto();
                                        $creargProyecto -> ctrCreargProyecto();
                                      ?>               
                                </form>
                              
                            </div>
                        </div> 
                </div> 
            </div>
        </section>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                  <!-- general form elements -->
                <div class="card card-primary">
                   <div class="card-body">
                        <table class="table table-striped table-bordered tablas" id="example_table_gproyecto" style="width:100%">
                            <thead>
                                <tr>
                                  <th></th>
                                  <th>EDITAR</th>
                                  <th>CONCEPTOS</th>
                                  <th>PROYECTO</th>
                                  <th>INGRESOS</th>
                                  <th>EGRESOS</th>
                                  <th>SALDO A FAVOR</th>
                                  <th>CLIENTE</th>
                                  <th>TIPO PROYECTO</th>
                                  <th>POTENCIA</th>
                                  <th>GENERACION ANUAL</th>
                                  <th>E. AUTOCONSUMO</th>
                                  <th>E. EXCEDENTES</th>
                                  <th>T. E. APLICADA</th>
                                  <th>T. E. GENERADA</th>
                                  <th>TRM(COP/USD)</th>
                                  <th>IMPUESTO RENTA</th>
                                  <th>DEPRECIACIÓN(AÑOS)</th>
                                  <th>IPC(%)</th>
                                  <th>DTF(%)</th>
                                  <th>INTERES BANCARIA(E/A)</th>
                                  <th>DESCRIPCION</th>
                                </tr> 
                            </thead>
                            <tbody>
                            <?php

                            $item = null;
                            $valor = null;


                              $items = ControladorgProyecto::ctrMostrargProyectos($item, $valor);
                              $operacionGanancia = 0;
                              foreach ($items as $key => $value)
                              {
                                
                                $operacionGanancia =  number_format(floatval($value["total_ingreso"] - $value["total_egreso"]),3);
                              echo ' <tr> 		                  
                                          <td class="details-control" vlr="'.$value["idgproyecto"].'">
                                          </td>
                                          <td>
                                            <div class="btn-group">
                                              <button class="btn btn-warning btnEditarProyectos" target="#ancla" onclick="editgProyecto(\''.$value["idgproyecto"].'\',\''.$value['nombregProyecto'].'\')"    data-toggle="modal" ><i class="far fa-edit"></i></button>
                                            </div>  
                                          </td>
                                          <td>
                                            <div class="btn-group">
                                              <button class="btn btn-warning btnInsertConcepto"  onclick=javascript:document.getElementById("gproyecto_idgproyecto").value=\''.$value["idgproyecto"].'\'     data-toggle="modal" data-target="#modalInsertConcepto"><i class="fas fa-plus"></i></button>
                                            </div>  
                                          </td>
                                          <td>'.$value["nombregProyecto"].'</td> 
                                          
                                          <td>$'.number_format($value["total_ingreso"],3).'</td> 
                                          <td>$'.number_format($value["total_egreso"],3).'</td> 
                                          <td>$'.$operacionGanancia.'</td> 

                                          <td>'.$value["nombreClienteProyecto"].'</td> 
                                          <td>'.$value["nombretipoProyecto"].'</td> 
                                          <td>'.$value["potenciagSistema"].'</td> 
                                          <td>'.$value["generacionaProyecto"].'</td> 
                                          <td>'.$value["energiaAutoconsumo"].'</td> 
                                          <td>'.$value["energiaExcedentes"].'</td> 
                                          <td>'.$value["tarifaAplicada"].'</td> 
                                          <td>'.$value["tarifaGenerada"].'</td> 
                                          <td>'.$value["trmDolar"].'</td> 
                                          <td>'.$value["impuestoRenta"].'</td> 
                                          <td>'.$value["depreciacion"].'</td> 
                                          <td>'.$value["ipc"].'</td> 
                                          <td>'.$value["dtf"].'</td> 
                                          <td>'.$value["interesBancario"].'</td> 
                                          <td>'.$value["descripcionProyecto"].'</td> 
                                      </tr>';
                              }


                              ?> 

                              </tbody>
                              <tfoot>
                              <tr>
                                <th></th>
                                <th>EDITAR</th>
                                <th>CONCEPTOS</th>
                                <th>PROYECTO</th>
                                <th>INGRESOS</th>
                                <th>EGRESOS</th>
                                <th>SALDO A FAVOR</th>
                                <th>CLIENTE</th>
                                <th>TIPO PROYECTO</th>
                                <th>POTENCIA</th>
                                <th>GENERACION ANUAL</th>
                                <th>E. AUTOCONSUMO</th>
                                <th>E. EXCEDENTES</th>
                                <th>T. E. APLICADA</th>
                                <th>T. E. GENERADA</th>
                                <th>TRM(COP/USD)</th>
                                <th>IMPUESTO RENTA</th>
                                <th>DEPRECIACIÓN(AÑOS)</th>
                                <th>IPC(%)</th>
                                <th>DTF(%)</th>
                                <th>INTERES BANCARIA(E/A)</th>
                                <th>DESCRIPCION</th>
                              </tr> 
                            </tfoot>
                            </table>
                          </div>
                
                </div>
              </div>
            </div>
          </div>                          
        </section>
</div>       
<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->
<div id="modalAgregarCliente" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
         
                  <div class="col-4">
                      <h4 class="modal-title"><i class="fas fa-user-plus"></i></h4>
                  </div>
                  <div class="col-4">
                     <label>Agregar cliente</label>
                  </div>
                  <div class="col-4">
                     <button type="button" id="closeW" class="close" data-dismiss="modal">&times;</button>
                  </div>        
      
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <form role="form" method="post" id="createClient" name="createClient" enctype="multipart/form-data"  >  
          <div class="modal-body">
            <div class="box-body">
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" name="nombreClienteProyecto" id="nombreClienteProyecto" onkeypress="validateOk(this.id)" placeholder="Nombre..." required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" name="emailCliente" id="emailCliente" onkeypress="validateOk(this.id)" placeholder="e-mail..." required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" name="telefonoCliente" id="telefonoCliente" onkeypress="validateOk(this.id)" placeholder="Teléfono..." required>
                  </div>
                </div>
              <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control" name="identificacionCliente" id="identificacionCliente" onkeypress="validateOk(this.id)" placeholder="Nit/C.C..." required>
                </div>
              </div>
            </div>
          </div>
        </form>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="button" class="btn btn-primary" onClick="saveCliente()">Guardar item</button>
        </div>
    </div>
  </div>
</div>
<!--=====================================
MODAL AGREGAR CONCEPTO
======================================-->
<div id="modalInsertConcepto" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
         
                  <div class="col-4">
                      <h4 class="modal-title"><i class="fas fa-chevron-right"></i></h4>
                  </div>
                  <div class="col-4">
                     <label>Agregar concepto</label>
                  </div>
                  <div class="col-4">
                     <button type="button" id="closeW" class="close" data-dismiss="modal">&times;</button>
                  </div>        
      
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <form role="form" method="post"> 
          <div class="modal-body">
            <div class="box-body">
              <!-- ENTRADA PARA EL CONCEPTO -->
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control" name="nombreConcepto" id="nombreConcepto"  placeholder="Nombre..." required>
                </div>
              </div>
            <!-- ENTRADA PARA LA UBICACION -->
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control" name="valor" id="valor"  placeholder="valor..." required>
                </div>
              </div>
                <!-- ENTRADA PARA LA FECHA REGISTRO -->
              <div class="form-group">
                <div class="input-group">
                <select id="movimiento_idmovimiento" name="movimiento_idmovimiento" class="form-control" required >
               </select>
                </div>
              </div>
              <!-- ENTRADA PARA LA FECHA -->
              <div class="form-group">
                <div class="input-group">
                  <input type="date" class="form-control" name="fecha" id="fecha"  placeholder="fecha..." required>
                </div>
              </div>
             <input type="hidden" name="gproyecto_idgproyecto" id="gproyecto_idgproyecto" value="" />
            </div>
         </div>
       
        <!--=====================================
        PIE DEL MODAL
        ======================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary" >Guardar item</button>
        </div>
        <?php
          $creargProyectoConcepto = new ControladorgProyecto();
          $creargProyectoConcepto -> ctrCreargProyectoConcepto();
        ?>
         </form>
    </div>
  </div>
</div>



<!-------------------------------------------------------------------------------------------------------------------->
