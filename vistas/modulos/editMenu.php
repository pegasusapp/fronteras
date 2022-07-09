<style>
 td {font-size: 14px};

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
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Menu de acceso</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Home</a></li>
              <li class="breadcrumb-item active">Permisos a <?php echo $_POST["identificadorMenu"] ?></li>
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
                  <div class="col-5">
                  <h3 class="card-title">Menu de acceso</h3>     
                  </div>
               </div>
               <div class="row">   
                <div class="col-4">
                 </div>
                 <div class="col-4" >
                      <div class="icon-bar">
                       <label>  Volver a usuarios</label> 
                         <a  id="iconAddUser"   title="Crear usuario" href="crearUsuario"><i class="fas fa-arrow-circle-left"></i></a>&nbsp; 
                         <a  id="iconSavePerfil" title="Guardar permisos"  href="#" onClick="saveMenu()" ><i class="fas fa-save"></i></a>&nbsp; 
                      </div>
                 </div> 
                 <div class="col-4">
                 </div> 
                </div> 
           
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <input type="hidden" name="usuario_sesionado" id="usuario_sesionado" value="<?php echo $_POST["identificadorMenu"] ?>" />
            <div id="treeview_container" class="hummingbird-treeview well h-scroll-large">
                     <ul id="treeview" class="hummingbird-base">
                     <?php 

                        //construimos el menu para el usuario en sesion
                        $valor_in = $_POST["identificadorMenu"];
              

                        $items_in = ControladorMenu::ctrMostrarMenu($valor_in);
                        $vector_gral_sesion = array();
          
                      foreach ($items_in as $key => $value)
                      {
                        
                                      $operacionidProcesoM=explode(",", $value["procesos_id"]);
                                    
                                      for ($j=0;$j<count($operacionidProcesoM); $j++)
                                        {
                                         
                                                      $operacionIdSubproceso=explode(",", $value["subprocesos_id"]);
          
                                                    for ($i=0; $i<count($operacionIdSubproceso); $i++)
                                                        {
                                                          $vlr_nodo_final ="";
                                                          $idsubproceso_brokenM = explode("-",$operacionIdSubproceso[$i]);
                                                       
                                                           if($operacionidProcesoM[$j]==$idsubproceso_brokenM[0])
                                                            {
                                                              $vlr_nodo_final = $value["idServicio"]."-".$operacionIdSubproceso[$i];
                                                              array_push($vector_gral_sesion,$vlr_nodo_final);
                                                             
                                                            }
                                                        }
                                           
                                        }
                                       
                        
                         
                        
                      
                        }
                        //fin

                   
                        $valor = null;
                      
                        $items = ControladorMenu::ctrMostrarMenu($valor);

                       
                        
                     foreach ($items as $key => $value)
                      {
                            echo '<li>
                                 <i class="fa fa-plus"></i>
                                   <label>
                                       <input id="node-'.$value["idServicio"].'" data-id="custom-'.$value["idServicio"].'"  type="checkbox" name="servicio[]"    />'.$value["nombreServicio"].'
                                   </label>
                                     <ul>';
                                        $operacionProceso=explode(",", $value["proceso_nombre"]);
                                        $operacionidProceso=explode(",", $value["procesos_id"]);
                                        for ($j=0;$j<count($operacionProceso); $j++)
                                          {
                                            echo '<li> <i class="fa fa-plus"></i>
                                                  <label><input  id="node-'.$value["idServicio"].'-'.$operacionidProceso[$j].'" name="proceso[]"   data-id="custom-'.$value["idServicio"].'-'.$operacionidProceso[$j].'" type="checkbox" />'.$operacionProceso[$j].'</label>
                                                    <ul>';
                                             
                                                $operacionSubproceso=explode(",", $value["nombreSubproceso"]);
                                                $operacionidSubproceso=explode(",", $value["subprocesos_id"]); 
                                              
                                                for ($i=0; $i<count($operacionSubproceso); $i++) 
                                                    {
                                                     
                                                      $idsubproceso_broken = explode("-",$operacionidSubproceso[$i]);
                                                    
                                                      if($operacionidProceso[$j]==$idsubproceso_broken[0])
                                                      {
                                                        echo '<li>
                                                            <label><input class="hummingbirdNoParent" id="'.$value["idServicio"].'-'.$operacionidProceso[$j].'-'.$idsubproceso_broken[1].'" name="subproceso[]"   data-id="custom-'.$value["idServicio"].'-'.$operacionidProceso[$j].'-'.$idsubproceso_broken[1].'" type="checkbox" />'.$operacionSubproceso[$i].'</label>
                                                            </li>';
                                                      }
                                                      
                                                          
                                                    }
                                        echo '</ul>';
                                        echo '</li>';         
                                        }
                                         
                                  


                            echo '</ul>
                              </li>';
                             
                        }
                     ?>

                        


                    </ul>



            </div> 
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

<!--=====================================
MODAL AGREGAR PERMISOS
======================================-->
<div id="modalAgregarPermisos" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

                  <div class="col-4">
                      <em class="far fa-id-card" ></em>
                  </div>
                  <div class="col-4">
                     <label>Agregar perfil</label>
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

          <div class="container">
          <div id="treeview_container" class="hummingbird-treeview well h-scroll-large">

              <ul id="treeview" class="hummingbird-base" id="menuUsuario">
      


                  


              </ul>



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

          $crearPerfil = new ControladorPerfil();
          $crearPerfil -> ctrCrearPerfil();

        ?>

      </form>

    </div>

  </div>

</div>

<!--=====================================
MODAL AGREGAR PERFIL
======================================-->

<div id="modalAgregarPerfil" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

                  <div class="col-4">
                      <i class="far fa-id-card" ></i>
                  </div>
                  <div class="col-4">
                     <label>Agregar perfil</label>
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

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
               <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresar nombre" required>

              </div>

            </div>

                            <!-- ENTRADA PARA LA DESCRIPCION -->
            
            <div class="form-group">
              
              <div class="input-group">
              

                <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Descripción" required></textarea>

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

          $crearPerfil = new ControladorPerfil();
          $crearPerfil -> ctrCrearPerfil();

        ?>

      </form>

    </div>

  </div>

</div>

<!--=====================================
MODAL AGREGAR USUARIO
======================================-->
<div id="modalAgregarUsuario" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
         
                  <div class="col-4">
                      <h4 class="modal-title"><em class="fas fa-user-plus" ></em></h4>
                  </div>
                  <div class="col-4">
                     <label>Agregar usuario</label>
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
            <!-- ENTRADA PARA LA CEDULA -->
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="identificador" id="identificador" placeholder="Ingresar login" required>
              </div>
            </div>
           <!-- ENTRADA PARA LA NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="nombreCompleto" id="nombreCompleto" placeholder="Ingresar nombre completo" required>
              </div>
            </div>
              <!-- ENTRADA PARA LA CONTRASEÑA -->
            <div class="form-group">
              <div class="input-group">
                  <input type="password" class="form-control" name="password" id="password" placeholder="Ingresar contraseña" required>
              </div>
            </div>
             <!-- ENTRADA PARA LA ESTADO -->
            <div class="form-group">
              <div class="input-group">
                <select class="form-control select2" name="estado" id="estado" title="Estado del usuario"  required>
                <option value="" >Seleccione el estado del usuario...</option>
                  <option value="1">Activo</option>
                  <option value="0">Inactivo</option>
                </select>  
              </div>
            </div>
               <!-- ENTRADA PARA EL EMAIL -->
            <div class="form-group">
              <div class="input-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Ingresar email" required>
              </div>
            </div>
              <!-- ENTRADA PARA EL PERFIl -->
            <div class="form-group">
               <div class="input-group">
                      <select class="form-control select2" id="idPerfilUsuarios" name="idPerfilUsuarios" title="Perfil del usuario" required>
                        <option value="" >Seleccione el perfil...</option>
                         <?php

                              $item  = null;
                              $valor = null;
                              $items = ControladorPerfil::ctrMostrarPerfil($item, $valor);
                              foreach ($items as $key => $value)
                                 {
                                   echo '<option value="'.$value["idPerfilUsuarios"].'">'.$value["nombre"].'  </option>';
                                 }
                          ?> 
                      </select>
                </div>
            </div>
                <!-- ENTRADA PARA EL CELULAR -->
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="celular" id="celular" placeholder="Ingresar celular" required>
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
          $crearUsuario = new ControladorUsuarios();
          $crearUsuario -> ctrCrearUsuario();
        ?>
      </form>
    </div>
  </div>
</div>
<!--=====================================
MODAL EDITAR USUARIO
======================================-->
<div id="modalEditarUsuario" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post">
          <input type="hidden"  name="editaridentificador" id="editaridentificador">
      <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar usuario</h4>
        </div>
        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="modal-body">
          <div class="box-body">
           <!-- ENTRADA PARA LA NOMBRE -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-id-card"></i></span> 
                <input type="text" class="form-control input-lg" name="editarnombreCompleto" id="editarnombreCompleto" required>
              </div>
            </div>
              <!-- ENTRADA PARA LA CONTRASEÑA -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 
                <input type="password" class="form-control input-lg" name="editarpassword" id="editarpassword" alt="contraseña" >
              </div>
            </div>
             <!-- ENTRADA PARA LA ESTADO -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-file"></i></span> 
                  <select class="form-control input-lg" name="editarestado" id="editarestado"  required>
                      <option value="1">Activo</option>
                      <option value="0">Inactivo</option>
                  </select>  
              </div>
            </div>
               <!-- ENTRADA PARA EL EMAIL -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 
                <input type="email" class="form-control input-lg" name="editaremail" id="editaremail"  required>
              </div>
            </div>
              <!-- ENTRADA PARA EL PERFIl -->
            <div class="form-group">
               <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-toggle-off"></i></span> 
                 <select class="form-control input-lg" id="editaridPerfilUsuarios" name="editaridPerfilUsuarios" required>
                      <option value="" >Seleccione el perfil...</option>
                     <?php
                          $item  = null;
                          $valor = null;
                          $items = ControladorPerfil::ctrMostrarPerfil($item, $valor);
                         foreach ($items as $key => $value)
                           {
                             echo '<option value="'.$value["idPerfilUsuarios"].'">'.$value["nombre"].'  </option>';
                           }
                       ?> 
                </select>
               </div>
            </div>
            <!-- ENTRADA PARA EL CELULAR -->
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-mobile"></i></span> 
                  <input type="text" class="form-control input-lg" name="editarcelular" id="editarcelular"  required>
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

          $editarUsuario = new ControladorUsuarios();
          $editarUsuario -> ctrEditarUsuario();

        ?> 

      </form>
    </div>
  </div>
</div>

<script type='text/javascript'>
$(document).ready(function() {
              
  $("#treeview").hummingbird();
// Collapsed Symbol
$.fn.hummingbird.defaults.collapsedSymbol= "fa-plus";

// Expand Symbol
$.fn.hummingbird.defaults.expandedSymbol= "fa-minus";

// Set this to "disabled" to disable all checkboxes from nodes that are parents
$.fn.hummingbird.defaults.checkboxesGroups= "enabled"; 

// Enable the functionality to account for disabled nodes
$.fn.hummingbird.defaults.checkDisabled= true;

// Collapse all nodes on init
$.fn.hummingbird.defaults.collapseAll= true; 

// Enable checkboxes
$.fn.hummingbird.defaults.checkboxes= "enabled"; 

<?php
                $js_array = json_encode($vector_gral_sesion);
                 echo "var javascript_array = ". $js_array . ";\n";
                ?>
              
 for(r=0;r<=javascript_array.length;r++)
  {
    $("#treeview").hummingbird("checkNode",
     {
	    attr:"id",
	    name: javascript_array[r],
	    expandParents:false
     });

  }
 
        });        
</script>
                     