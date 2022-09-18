
 <?php
				$valor = $_SESSION["identificador"];
        $item = "identificador";
        $items = ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
       ?>
<form id="myForm"  role="form" method="POST" enctype="multipart/form-data">
    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
           </div>
        <div class="card-body">
          <div class="row">
              <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputNombre">Nombre</label>
                      <input type="text" class="form-control" id="editarnombreCompleto" name="editarnombreCompleto"  value="<?php echo $items["nombreCompleto"]; ?>" />
                  </div>
                  <div class="form-group">
                    <label for="exampleInputLg">Imagen:</label>
                    <?php
                        if($items['nuevaFoto'] != "vistas/img/usuarios/default/anonymous.png" && $items['nuevaFoto'] != "" ):?>
                    
                            <div class="user-panel mt-1 pb-3 mb-3 d-flex">
                                <div class="image">
                                  <img src="<?=$items['nuevaFoto']?>" class="img-circle elevation-2" alt="Imagen de perfil de <?=$items["identificador"]?>" />
                                </div>
                                <input type="file" class="form-control" id="nuevaFoto" name="nuevaFoto" accept="image/x-png,image/gif,image/jpeg">
                             </div>
                        <?php else: ?> 
                            <div class="user-panel mt-1 pb-3 mb-3 d-flex">
                              <div class="image">
                                <img src="vistas/img/usuarios/default/anonymous.png" class="img-circle elevation-2" alt="Imagen de perfil de '.$items["identificador"].'"/>
                              </div>
                              <input type="file" class="form-control" id="nuevaFoto" name="nuevaFoto" accept="image/x-png,image/gif,image/jpeg">
                            </div>
                        <?php endif;?>    
                      <input type="hidden" class="form-control" id="editarnuevaFoto" name="editarnuevaFoto" value="<?php echo $items["nuevaFoto"]; ?>"/>
                      <input type="hidden" class="form-control" id="editaridentificador" name="editaridentificador" value="<?php echo $items["identificador"]; ?>"/>
                  </div>
              </div>  
            <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEtd">estado</label>
                  <input type="hidden" class="form-control" id="editarestado" name="editarestado" value="1"/>
                  <input type="text" class="form-control" id="estadoFronteraA" disabled name="estadoFronteraA" value="<?= $r = ('1' == $items["estado"]) ? 'Activo' : 'Inactivo'; ?>" />


                </div>
                <div class="form-group">
                  <label for="exampleInputEmail">email</label>
                    <input type="email" class="form-control" id="editaremail" name="editaremail" value="<?= $items["email"]?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                <label for="exampleInputPfl">Perfil</label>
                <div class="form-group">
               <div class="input-group">
                 <select class="form-control input-lg" id="idPerfilUsuarios" name="idPerfilUsuarios" disabled>
                      <option value="" >Seleccione el perfil...</option>
                     <?php
                          $item  = null;
                          $valor = null;
                          $itemsp = ControladorPerfil::ctrMostrarPerfil($item, $valor);
                          $selected_perfil="";
                         foreach ($itemsp as $key => $value): ?>
                              <?php 
                                  if ($value["nombre"]==$items["nombre"]){
                                         $selected_perfil="selected";
                                      }
                                  else{
                                         $selected_perfil="";
                                      }?> 
                             <option value="<?=$value["idPerfilUsuarios"]?>" <?=$selected_perfil?>>
                                 <?=$value["nombre"]?>
                             </option>
                           <?php endforeach;?>
                       
                </select>
                <input type="hidden" name="editaridPerfilUsuarios"  id="editaridPerfilUsuarios" value="<?php echo $items["idPerfilUsuarios"]; ?>" />
               </div>
            </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputtlf">Teléfono</label>
                    <input type="text" class="form-control" id="editarcelular" name="editarcelular" value="<?php echo $items["celular"]; ?>" >
                </div>
            </div>
 
           </div>
           <div class="row">
           <div class="col-md-4">
           <div class="form-group">
                <label for="exampleInputPfl">Nueva contraseña</label>
                    <input type="password" class="form-control" id="editarpassword" name="editarpassword" value="" />
                </div>
           </div>

           </div>
           <div class="row">
          	<div class="col-md-12">
                <div class="form-group">
                  <label for="exampleInputvsi"></label>
                      <button data-trans class="btn btn-block btn-primary" type="submit">Guardar cambios</button>
                </div>	
          	</div>
          </div>
        </div> <!--card-body -->
      </div> <!-- card card-default-->
    </div> <!-- container-fluid-->
   <input type="hidden" id="paginar" name="paginar" value="datosPersonales" />
  </section>
  <?php
    
    $editarUsuario = new ControladorUsuarios();
    $editarUsuario -> ctrEditarUsuario();
    
   
  ?>
  </form>

</div>
