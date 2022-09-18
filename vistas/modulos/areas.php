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
            <h1>Areas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Home</a></li>
              <li class="breadcrumb-item active">Administrar areas</li>
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
                  <h3 class="card-title">Listado de areas</h3>     
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
                       <a data-toggle="modal" data-target="#modalAgregarArea" id="iconAddUser"   title="Crear area" href="#"><i class="fas fa-location-arrow"></i></a>&nbsp; 
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
                  <th>PLANTA</th>
                  <th>OPCION</th>
                </tr> 
              </thead>
        <tbody>
        <?php
	       
	        $item = null;
	        $valor = null;
    		$items = ControladorAreas::ctrMostrarAreas($item, $valor);

		       foreach ($items as $key => $value)
		       {
		         
		          echo ' <tr>
                        <td>'.$value["nombreArea"].'</td> 
                        <td>'.$value["nombrePlanta"].'</td> 
		                  <td>
		                    <div class="btn-group">
		                      <button class="btn btn-warning btnEditarAreas" onclick=editArea("'.$value["idarea"].'")    data-toggle="modal" data-target="#modalEditarArea"><i class="far fa-edit"></i></button>
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
MODAL AGREGAR PLANTA
======================================-->
<div id="modalAgregarArea" class="modal fade" role="dialog">
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
                     <label>Agregar area</label>
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
                <input type="text" class="form-control" name="nombreArea" id="nombreArea" placeholder="Nombre area" required>
              </div>
            </div>
   <!-- ENTRADA PARA EL PERFIl -->
            <div class="form-group">
               <div class="input-group">
                 <select class="form-control input-lg" id="proyecto_idproyecto" name="proyecto_idproyecto" required>
                      <option value="" >Seleccione la planta a donde pertenece...</option>
                     <?php
                          $item  = null;
                          $valor = null;
                          $items = ControladorProyectos::ctrMostrarProyectos($item, $valor);
                         foreach ($items as $key => $value)
                           {
                             echo '<option value="'.$value["idproyecto"].'">'.$value["nombrePlanta"].'  </option>';
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
          $crearArea = new ControladorAreas();
          $crearArea -> ctrCrearArea();
        ?>
      </form>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR AREA
======================================-->

<div id="modalEditarArea" class="modal fade" role="dialog">
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
                     <label id="lbl_proyecto_anuncio">Editar Area </label>
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
                <input type="text" class="form-control input-lg"  name="nombreAreaE" id="nombreAreaE" placeholder="Ingresar nombre area" required>
                <input type="hidden"  name="idareaE" id="idareaE" value="">
              </div>
            </div>
                        <!-- ENTRADA PARA EL UBICACION -->
            <div class="form-group">
               <div class="input-group">
                 <select class="form-control input-lg" id="proyecto_idproyectoE" name="proyecto_idproyectoE" required>
                      <option value="" >Seleccione la planta a donde pertenece...</option>
                     <?php
                          $item  = null;
                          $valor = null;
                          $items = ControladorProyectos::ctrMostrarProyectos($item, $valor);
                         foreach ($items as $key => $value)
                           {
                             echo '<option value="'.$value["idproyecto"].'">'.$value["nombrePlanta"].'  </option>';
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

          $editarAreas = new ControladorAreas();
          $editarAreas -> ctrEditarArea();

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
