<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar opciones de respuesta
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar opciones de respuesta</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarOpcion">
          
          Agregar opciones de respuesta

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas">
         
        <thead>
         
         <tr>
           
          
           <th>Descripcion</th>
           <th>Presentacion</th>
           <th>Etiquetas</th>
           <th>Valores</th>
           <th>Opciones</th>
         </tr> 

        </thead>

        <tbody>

        <?php

        $item = null;
        $valor = null;

        $items = ControladorOpcionvalor::ctrMostrarOpcionValor($item, $valor);

       foreach ($items as $key => $value){
         
          echo ' <tr>
                  
                
                  <td>'.$value["descripcion"].'</td>
                  <td>'.$value["forma"].'</td>
                  <td>'.$value["etiquetas"].'</td>
                  <td>'.$value["valores"].'</td>
                  <td>
                    <div class="btn-group">
                        
                      <button class="btn btn-warning btnEditarOpcionValor" idOpcionValor="'.$value["idopciones_valor"].'" data-toggle="modal" data-target="#modalEditarOpcionValor"><i class="fa fa-pencil"></i></button>
                    </div>  

                  </td>

                </tr>';
        }


        ?> 

        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR OPCION
======================================-->

<div id="modalAgregarOpcion" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form"  autocomplete="off" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar opción</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body" id="containeradd">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-file"></i></span> 

                <input type="text" class="form-control input-lg" name="descripcion" id="descripcion" placeholder="Ingresar la descripcion de la opción" required>

              </div>

            </div>
            <div class="form-group">
              <label for="inputKey" class="col-md-1 control-label">Etiqueta</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="etiqueta" name="etiqueta" placeholder="Key">
                </div>
              <label for="inputValue" class="col-md-1 control-label">Valor</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="valor" name="valor" placeholder="Value">
                </div>
              <span class="input-group-btn">
               <button class="btn btn-success btn-add" type="button" onclick="AddOption()">
                    <span class="glyphicon glyphicon-plus"></span>
               </button>
              </span>
            </div>

              
             <!-- <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-file"></i></span> 

                <input type="text" class="form-control input-lg" name="etiquetas" id="etiquetas" placeholder="Ingresar etiquetas separadas por coma (,)" required>

              </div>
              
            </div>

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-file"></i></span> 

                <input type="text" class="form-control input-lg" name="valores" id="valores" placeholder="Ingresar valores separados por coma (,)" required>

              </div>
            </div> -->
            </div>
            <div class="box-body" id="containeradd2">
            <div class="form-group">
              
              <div class="input-group">
                        <div class="check">Presentación:  
                              <label>
                                                Listado: <input type="radio" checked id="FormaOpcion1" name="FormaOpcion" value="1">
                                                Botones: <input type="radio" id="FormaOpcion2" name="FormaOpcion" value="2">
                              </label>
                       </div> 
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

          $crearOpcionValor = new ControladorOpcionvalor();
          $crearOpcionValor-> ctrCrearOpcionValor();

        ?>

      </form>

    </div>

  </div>

</div>
<!--=====================================
MODAL EDITAR OPCION
======================================-->

<div id="modalEditarOpcionValor" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar opción </h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
           <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-file"></i></span> 

                <input type="text" class="form-control input-lg" name="editarDescripcion" id="editarDescripcion" value="" required>

              </div>

            </div>   
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <input type="text" class="form-control input-lg" name="editarEtiquetas" id="editarEtiquetas" value="" required>

                <input type="hidden"  name="idopciones_valor" id="idopciones_valor" value="" />

              </div>
           </div>
          <div class="form-group">   
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-file"></i></span> 

                <input type="text" class="form-control input-lg" name="editarValores" id="editarValores" required>

              </div>
          </div> 
           <div class="form-group">    
              <div class="input-group">
                        <div class="check">Presentación: 
                              <label>
                                                Listado: <input type="radio"  name="editarFormaOpcion" value="1" />
                                                Botones: <input type="radio"  name="editarFormaOpcion" value="2" />
                              </label>
                       </div> 
             </div>
          </div>   

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

          $editarOpcionValor = new ControladorOpcionvalor();
          $editarOpcionValor-> ctrEditarOpcionValor();

        ?> 

      </form>

    </div>

  </div>

</div>
