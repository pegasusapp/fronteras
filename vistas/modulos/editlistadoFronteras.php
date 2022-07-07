<!--=====================================
MODAL EDITAR FRONTERA
======================================-->
<div id="modalEditarFrontera" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" aria-labelledby="mainnavheadingtwo">
        <input type="hidden"  name="editaridentificador" id="editaridentificador">
          <div class="modal-header" style="background:#3c8dbc; color:white">
            <div class="col-4">
                <h4 class="modal-title"><em class="far fa-edit"></em></h4>
            </div>
            <div class="col-4">
              <label>Opciones de la frontera</label>
            </div>
            <div class="col-4">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>        

        </div>
       <div class="modal-body">
          <div class="box-body">
            <div class="form-group">
              <div class="input-group">
                  <select class="form-control select2" name="seguimientoeditar" id="seguimientoeditar" title="Seguimiento energia penalizada"  required>
                    <option value="" >Seguimiento usuario...</option>
                    <option value="S">SI</option>
                    <option value="N">NO</option>
                  </select>  
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                 <input type="text" name="editarminimoKv" id="editarminimoKv" class="form-control" placeholder="Cantidad min Kv para alertar" value="" />
              </div>
            </div>
           </div>
        </div>
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

<div id="modalGeneraraReporte" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" action="datosGenerados" aria-labelledby="mainnavheading">
          <input type="hidden"  name="fronteraReporte" id="fronteraReporte" value="" />
           <div class="modal-header" style="background:#3c8dbc; color:white">
              <div class="col-4">
                  <h4 class="modal-title"><em class="far fa-edit"></em></h4>
              </div>
              <div class="col-4">
                  <label>Generar matriz de lecturas</label>
              </div>
              <div class="col-4">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>        
           </div>
           <div class="modal-body">
             <div class="box-body">
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
         </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Generar datos</button>
        </div>
      </form>
    </div>
  </div>
</div>

