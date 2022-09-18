<section class="content">
  <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
             
              <div class="row">
                  <div class="col-5">
                  <h3 class="card-title">Listado de usuarios</h3>     
                  </div>
               </div>
               <div class="row">   
                <div class="col-4">
                 </div>
                 <div class="col-4" >
                      <div class="icon-bar">
                        <a data-toggle="modal" data-target="#modalAgregarUsuario" onClick="starCreateUser()" id="iconAddUser"   title="Crear usuario" href="#"><i class="fas fa-user-plus" ></i></a>&nbsp; 
                        <a data-toggle="modal" data-target="#modalAgregarPerfil"  id="iconAddPerfil" title="Crear perfil"  href="#"><i class="far fa-id-card"></i></a>&nbsp; 
                      </div>
                 </div> 
                 <div class="col-4">
                 </div> 
                </div> 
           
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive tablas">
              <caption>Listado de usuarios</caption>
               <thead>
                <tr>
                  <th id ="login">LOGIN</th>
                  <th id ="nameCrearUser">NOMBRE</th>
                  <th id ="celularCrearUser">CELULAR</th>
                  <th id ="perfilCrearUser">PERFIL</th>
                  <th id ="estadoCrearUser">ESTADO</th>
                  <th id ="emailCrearUser">EMAIL</th>
                  <th id ="optCrearUser">OPCIONES</th>
                </tr> 
                </thead>
                <tbody>
                <?php
                $item = null;
                $valor = null;
                $items = ControladorUsuarios::ctrMostrarUsuarios($item, $valor); 
                foreach ($items as $key => $value)
                    {
                        $r = (1 == $value["estado"]) ? 'Activo' : 'Inactivo'; 
                    
                    ?>    
                         <tr>
                                    <td><?= $value["identificador"] ?></td>
                                    <td><?= $value["nombreCompleto"] ?></td> 
                                    <td><?= $value["celular"] ?></td>
                                    <td><?= $value["nombre"] ?></td>
                                    <td><?= $r ?></td> 
                                    <td><?= $value["email"] ?></td>
                                    <td>
                                    <div class="btn-group">
                                       <button class="btn btn-primary px-2.5" onclick=editarUser('<?= $value["identificador"] ?>') codigoniu="<?= $value["identificador"] ?>" data-toggle="modal" data-target="#modalEditarUsuario"><i class="far fa-edit" aria-hidden="true"></i></button>
                                    </div> 
                                    <div class="btn-group">
                                          <button class="btn btn-primary px-2.5"  onclick=editarMenu('<?= $value["identificador"] ?>') codigoniu="<?= $value["identificador"] ?>" ><i class="fas fa-lock" aria-hidden="true"></i></button>
                                      </div>
                                    </td>
                                </tr>
                <?php
                  }
                ?> 
                </tbody>
                <tfoot>
                <tr>
                <th id ="login">LOGIN</th>
                  <th id ="nameCrearUser">NOMBRE</th>
                  <th id ="celularCrearUser">CELULAR</th>
                  <th id ="perfilCrearUser">PERFIL</th>
                  <th id ="estadoCrearUser">ESTADO</th>
                  <th id ="emailCrearUser">EMAIL</th>
                  <th id ="optCrearUser">OPCIONES</th>
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

<!--=====================================
MODAL AGREGAR PERMISOS
======================================-->
<div id="modalAgregarPermisos" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data" aria-labelledby="form">

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
                  <ul id="treeview" class="hummingbird-base" id="menuUsuario"></ul>
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

      <form role="form" method="post" enctype="multipart/form-data" aria-labelledby="formdataperfil">

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
<?php
      $item  = null;
      $valor = null;
      $items = ControladorPerfil::ctrMostrarPerfil($item, $valor);
      foreach ($items as $key => $value)
        {
          $vlrUsuarios.='<option value="'.$value["idPerfilUsuarios"].'">'.$value["nombre"].'</option>';
        } 
?> 

<!--=====================================
MODAL AGREGAR USUARIO
======================================-->
<div id="modalAgregarUsuario" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data" aria-labelledby="formdatauser">
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
                      <select class="form-control select2" id="idPerfilUsuarios"  name="idPerfilUsuarios" title="Perfil del usuario" required>
                        <option value="" >Seleccione el perfil...</option>
                         <?php
                            echo $vlrUsuarios;
                         ?> 
                      </select>
                </div>
            </div>
               <!-- ENTRADA PARA LA PLANTA -->
            <div class="form-group" id="perfil_planta_div">
               <div class="input-group">
                      <select class="form-control select2" id="proyecto_id" name="proyecto_id" title="Seleccione la planta" >
                      <option value="" >
                      </option>
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
      <form role="form" method="post" aria-labelledby="formdataedituser">
          <input type="hidden"  name="editaridentificador" id="editaridentificador">
      <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
       

        <div class="modal-header" style="background:#3c8dbc; color:white">
         
         <div class="col-4">
             <h4 class="modal-title"><em class="far fa-edit"></em></h4>
         </div>
         <div class="col-4">
            <label>Editar usuario</label>
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
           <!-- ENTRADA PARA LA NOMBRE -->
           <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="editarnombreCompleto" id="editarnombreCompleto" required>
              </div>
            </div>
              <!-- ENTRADA PARA LA CONTRASEÑA -->
            <div class="form-group">
              <div class="input-group">
                <input type="password" class="form-control" name="editarpassword" placeholder="Nueva contraseña" id="editarpassword" alt="contraseña" >
              </div>
            </div>
             <!-- ENTRADA PARA LA ESTADO -->
            <div class="form-group">
              <div class="input-group">
                  <select class="form-control" name="editarestado" id="editarestado"  required>
                      <option value="1">Activo</option>
                      <option value="0">Inactivo</option>
                  </select>  
              </div>
            </div>
               <!-- ENTRADA PARA EL EMAIL -->
            <div class="form-group">
              <div class="input-group">
                <input type="email" class="form-control" name="editaremail" id="editaremail" placeholder="Nuevo email"  required>
              </div>
            </div>
              <!-- ENTRADA PARA EL PERFIl -->
            <div class="form-group">
               <div class="input-group">
                 <select class="form-control" id="editaridPerfilUsuarios" Onchange="opcionPerfil(this.value)" name="editaridPerfilUsuarios" required>
                      <option value="" >Seleccione el perfil...</option>
                     <?php echo $vlrUsuarios; ?>
                </select>
               </div>
            </div>
            <!-- ENTRADA PARA EL CELULAR -->
            <div class="form-group">
              <div class="input-group">
                  <input type="text" class="form-control" name="editarcelular" id="editarcelular" placeholder="Nuevo numero celular"  required>
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

          $editarUsuario = new ControladorUsuarios();
          $editarUsuario -> ctrEditarUsuario();
            
        ?> 

      </form>
    </div>
  </div>
</div>
<form method="post" name="form_editMenu" id="form_editMenu" action="editMenu">    
    <input id="identificadorMenu" name="identificadorMenu" type="hidden" value="" />
</form>