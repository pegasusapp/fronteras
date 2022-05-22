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
</style>
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Perfiles</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Home</a></li>
              <li class="breadcrumb-item active">Administrar perfiles</li>
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
                  <h3 class="card-title">Listado de perfiles</h3>     
                  </div>
               </div>
               <div class="row">   
                  <!--<div class="col-5">
                  <button type="button" class="btn btn-rounded btn-primary"  data-toggle="modal" data-target="#modalAgregarUsuario"><i class="fas fa-user-plus" ></i> Añadir usuarios</button>
                </div> -->
                <div class="col-4">
                 </div>
                 <div class="col-4" >
                      <div class="icon-bar">
                       <a data-toggle="modal" data-target="#modalAgregarPerfil" id="iconAddUser"   title="Crear perfil" href="#"><i class="fas fa-location-arrow"></i></a>&nbsp; 
                       <!--<a href="#"><i class="fas fa-lock"></i></a> &nbsp;
                        <a href="#"><i class="fa fa-globe"></i></a> -->
                      </div>
                 </div> 
                 <div class="col-4">
                 </div> 
                </div> 
           
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped tablas" style="width:100%">
                <thead>
                <tr>
                  <th>NOMBRE</th>
                  <th>FUENTE ENERGIA</th>
                  <th>OPCION</th>
                </tr> 
              </thead>
        <tbody>
        <?php
	       
	        $item = null;
	        $valor = null;
    		$items = ControladorPerfiles::ctrMostrarPerfiles($item, $valor);

		       foreach ($items as $key => $value)
		       {
		         
		          echo ' <tr>
                        <td>'.$value["nombre"].'</td> 
                        <td>'.$value["nombreFuente"].'</td> 
		                  <td>
		                    <div class="btn-group">
		                      <button class="btn btn-warning btnEditarPerfiles" onclick=editPerfil("'.$value["idperfilEnergia"].'")    data-toggle="modal" data-target="#modalEditarPerfil"><i class="far fa-edit"></i></button>
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
                      <h4 class="modal-title"><i class="fas fa-location-arrow"></i></h4>
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
            <!-- ENTRADA PARA LA PLANTA -->
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre perfil" required>
              </div>
            </div>
   <!-- ENTRADA PARA EL PERFIl -->
            <div class="form-group">
               <div class="input-group">
                 <select class="form-control input-lg" id="fuenteEnergia_idfuenteEnergia" name="fuenteEnergia_idfuenteEnergia" required>
                      <option value="" >Seleccione la fuente a donde pertenece...</option>
                     <?php
                          $item  = null;
                          $valor = null;
                          $items = ControladorFuentes::ctrMostrarFuentes($item, $valor);
                         foreach ($items as $key => $value)
                           {
                             echo '<option value="'.$value["idfuenteEnergia"].'">'.$value["nombreFuente"].'  </option>';
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
          $crearArea = new ControladorPerfiles();
          $crearArea -> ctrCrearPerfil();
        ?>
      </form>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR PERFIL
======================================-->

<div id="modalEditarPerfil" class="modal fade" role="dialog">
  <div class="modal-dialog">
   <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
         
                  <div class="col-2">
                      <h4 class="modal-title"><i class="fas fa-location-arrow" ></i></h4>
                  </div>
                  <div class="col-8">
                     <label id="lbl_proyecto_anuncio">Editar perfil </label>
                  </div>
                  <div class="col-2">
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
                <input type="text" class="form-control input-lg"  name="nombreE" id="nombreE" placeholder="Ingresar nombre perfil" required>
                <input type="hidden"  name="idperfilEnergiaE" id="idperfilEnergiaE" value="">
              </div>
            </div>
                        <!-- ENTRADA PARA EL UBICACION -->
            <div class="form-group">
               <div class="input-group">
               <select class="form-control input-lg" id="fuenteEnergia_idfuenteEnergiaE" name="fuenteEnergia_idfuenteEnergiaE" required>
                      <option value="" >Seleccione la fuente a donde pertenece...</option>
                     <?php
                          $item  = null;
                          $valor = null;
                          $items = ControladorFuentes::ctrMostrarFuentes($item, $valor);
                         foreach ($items as $key => $value)
                           {
                             echo '<option value="'.$value["idfuenteEnergia"].'">'.$value["nombreFuente"].'  </option>';
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

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      <?php

          $editarPerfil = new ControladorPerfiles();
          $editarPerfil -> ctrEditarPerfil();

          $paginaNiveles =  $_SERVER["REQUEST_URI"];
          $paginaSesion = explode("/", $paginaNiveles);
          $valor = $paginaSesion[2];
          $items = ControladorMenu::ctrMostrarMenuExpandido($valor);
          foreach ($items as $key => $value)
          {
            echo "<script>
            document.getElementById('servicio_".$value["idServicio"]."').className = 'nav-item has-treeview menu-close menu-open';
            document.getElementById('proceso_".$value["idProceso"]."').className = 'nav-item has-treeview menu-close menu-open';
            document.getElementById('subproceso_".$value["idSubproceso"]."').className ='far fa-circle nav-icon text-danger';
                  </script>";
          }

        ?> 

      </form>

    </div>

  </div>

</div>
