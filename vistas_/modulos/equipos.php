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
              <li class="breadcrumb-item active">Administrar equipos</li>
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
                  <h3 class="card-title">Listado de equipos</h3>     
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
                       <a data-toggle="modal" data-target="#modalAgregarEquipo" id="iconAddUser"   title="Crear equipo" href="#"><i class="fas fa-location-arrow"></i></a>&nbsp; 
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
              <table class="table table-striped table-bordered tablas" style="width:100%">
                <thead>
                <tr>
                  <th>PLANTA</th>  
                  <th>AREA</th>
                  <th>NOMBRE</th>
                  <th>UNIDADES</th>
                  <th>HORAS/USO/DIA</th>
                  <th>DIAS/USO/MES</th>
                  <th>PERFIL</th>
                  <th>POTENCIAS</th>
                  <th>OPCION</th>
                </tr> 
              </thead>
        <tbody>
        <?php
	       
	        $item = null;
	        $valor = null;
    		$items = ControladorEquipos::ctrMostrarEquipos($item, $valor);

		       foreach ($items as $key => $value)
		       {
		         
		          echo ' <tr>
                        <td>'.$value["nombrePlanta"].'</td> 
                        <td>'.$value["nombreArea"].'</td> 
                        <td>'.$value["nombreEquipo"].'</td> 
                        <td>'.$value["unidades"].'</td> 
                        <td>'.$value["horasUsoDia"].'</td> 
                        <td>'.$value["diasUsoMes"].'</td> 
                        <td>'.$value["nombre"].'</td> 
                        <td>'.$value["nombrePotencia"].'-'.$value["cantidad"].$value["unidad"].'</td> 
                        <td>
		                    <div class="btn-group">
		                      <button class="btn btn-warning btnEditarAreas" onclick=editEquipo("'.$value["idequipo"].'")    data-toggle="modal" data-target="#modalEditarEquipo"><i class="far fa-edit"></i></button>
		                    </div>  
		                  </td>
		                </tr>';
		        }


        ?> 

        </tbody>
        <tfoot>
                <tr>
                <th>PLANTA</th>  
                  <th>AREA</th>
                  <th>NOMBRE</th>
                  <th>UNIDADES</th>
                  <th>HORAS/USO/DIA</th>
                  <th>DIAS/USO/MES</th>
                  <th>PERFIL</th>
                  <th>POTENCIAS</th>
                  <th>OPCION</th>
                </tr>  
        </tfoot>          
       </table>
      </div>
    </div>
  </section>

</div>
<!--=====================================
MODAL AGREGAR PLANTA
======================================-->
<div id="modalAgregarEquipo" class="modal fade" role="dialog">
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
                     <label>Agregar equipo</label>
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
            <div class="row">
             <div class="col-sm-6">
              <div class="form-group">
                <div class="input-group">
                  <input type="text" class="form-control" name="nombreEquipo" id="nombreEquipo" placeholder="Nombre equipo" required>
                </div>
              </div>
             </div> 
               <!-- ENTRADA PARA LAS UNIDADES -->
            <div class="col-sm-6">  
             <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="unidades" id="unidades" placeholder="Unidades..." required>
              </div>
            </div>
           </div>
          </div>  
              <!-- ENTRADA PARA EL AREA -->
            <div class="form-group">
               <div class="input-group">
                 <select class="form-control input-lg" id="area_idarea" name="area_idarea" required>
                      <option value="" >Seleccione el area a donde pertenece...</option>
                     <?php
                          $item  = null;
                          $valor = null;
                          $items = ControladorAreas::ctrMostrarAreas($item, $valor);
                         foreach ($items as $key => $value)
                           {
                             echo '<option value="'.$value["idarea"].'">'.$value["nombreArea"].'  </option>';
                           }
                       ?> 
                </select>
               </div>
            </div>
            
             <!-- ENTRADA PARA LAS HORAS/DIA -->
             <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="horasUsoDia" id="horasUsoDia" placeholder="Horas..." required>
                    </div>
                  </div>
             </div>     
            <!-- ENTRADA PARA LAS DIASUSO/MES -->
           <div class="col-sm-6">
             <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="diasUsoMes" id="diasUsoMes" placeholder="Dias..." required>
              </div>
            </div>
           </div> 
          </div>    
              <!-- ENTRADA PARA EL PERFIL -->
              <div class="form-group">
               <div class="input-group">
                 <select class="form-control input-lg" id="perfilEnergia_idperfilEnergia" name="perfilEnergia_idperfilEnergia" required>
                      <option value="" >Seleccione el perfil a donde pertenece...</option>
                     <?php
                          $item  = null;
                          $valor = null;
                          $items = ControladorPerfiles::ctrMostrarPerfiles($item, $valor);
                         foreach ($items as $key => $value)
                           {
                             echo '<option value="'.$value["idperfilEnergia"].'">'.$value["nombre"].'  </option>';
                           }
                       ?> 
                </select>
               </div>
            </div>
           <!-- ENTRADA PARA LAS OBSERVACIONES -->
           <div class="form-group">
              <div class="input-group">
                <textarea class="form-control" name="observaciones" id="observaciones" placeholder="observaciones..." required></textarea>
              </div>
            </div> 

          <!-- ENTRADA PARA LAS POTENCIAS -->
          <div class="row">
              
                
                
                     <?php
                          $item  = null;
                          $valor = null;
                          $items = ControladorPotencias::ctrMostrarPotencias($item, $valor);
                          foreach ($items as $key => $value)
                            {
                        
                              echo ' <div class="col-sm-6">
                                       <div class="form-group">
                                         <div class="form-check">
                                              <input class="form-check-input" onClick="habilitarText(this.value)" type="checkbox" name="tipoPotencia_idtipoPotencia[]" value="'.$value["idtipoPotencia"].'">
                                              <label class="form-check-label">'.$value["nombrePotencia"].'</label>
                                         </div>
                                         <div class="input-group">
                                              <input type="text" class="form-control" disabled name="cantidad_'.$value["idtipoPotencia"].'" id="cantidad_'.$value["idtipoPotencia"].'" placeholder="Cantidad..." value=0 />
                                         </div>
                                      </div>
                                    </div>  '; 
                            }
                       ?> 
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
          $crearEquipos = new ControladorEquipos();
          $crearEquipos -> ctrCrearEquipo();
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
