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
            <h1>Usuarios</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Home</a></li>
              <li class="breadcrumb-item active">Administrar facturas</li>
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
                  <h3 class="card-title">Listado de facturas</h3>     
                  </div>
               </div>
               <div class="row">   
                <div class="col-4">
                 </div>
                 <div class="col-4" >
                      <div class="icon-bar">
                        <a data-toggle="modal" data-target="#modalAgregarFactura"  id="iconAddUser"   title="Crear factura" href="#"><i class="fas fa-user-plus" ></i></a>&nbsp; 
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
                  <th>AÑO</th>
                  <th>MES</th>
                  <th>ARCHIVO</th>
                  <th>OPCIONES</th>
                </tr> 
                </thead>
                <tbody>
                <?php
                $item = null;
                $valor = null;
                $items = ControladorUsuarios::ctrMostrarUsuarios($item, $valor); 
                foreach ($items as $key => $value)
                    {
                        echo ' <tr>
                                    <td>'.$value["anyo"].'</td>
                                    <td>'.$value["mes"].'</td> 
                                    <td>'.$value["nameFile"].'</td>
                                    <td>
                                        <div class="btn-group">
                                          <button class="btn btn-primary px-2.5" onclick=editarUser("'.$value["identificador"].'") codigoniu="'.$value["identificador"].'" data-toggle="modal" data-target="#modalEditarUsuario"><i class="far fa-edit" aria-hidden="true"></i></button>
                                        </div> 
                                      <div class="btn-group">
                                          <button class="btn btn-primary px-2.5"  onclick=editarMenu("'.$value["identificador"].'") codigoniu="'.$value["identificador"].'" ><i class="fas fa-lock" aria-hidden="true"></i></button>
                                      </div>     
                                    </td>
                                </tr>';
                    }
                ?> 
                </tbody>
                <tfoot>
                <tr>
                  <th>AÑO</th>
                  <th>MES</th>
                  <th>ARCHIVO</th>
                  <th>OPCIONES</th>
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
MODAL AGREGAR FACTURA
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

         // $crearFactura = new ControladorFactura();
         // $crearFactura -> ctrCrearFactura();

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
MODAL AGREGAR FACTURA
======================================-->
<div id="modalAgregarFactura" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
         
                  <div class="col-4">
                      <h4 class="modal-title"><i class="fas fa-user-plus" ></i></h4>
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
                            $yearActual= Date(Y); 
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
                              $items = ControladorPerfil::ctrMostrarPerfil($item, $valor);
                              foreach ($items as $key => $value)
                                 {
                                   echo '<option value="'.$value["idPerfilUsuarios"].'">'.$value["nombre"].'  </option>';
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
         
         <div class="col-4">
             <h4 class="modal-title"><i class="far fa-edit"></i></h4>
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
                  <input type="text" class="form-control" name="editarcelular" id="editarcelular" placeholder="Nuevo numero celular"  required>
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
<form method="post" name="form_editMenu" id="form_editMenu" action="editMenu">    
    <input id="identificadorMenu" name="identificadorMenu" type="hidden" value="" />
</form>