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
</style>
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Listado de plantas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Home</a></li>
              <li class="breadcrumb-item active">Administrar Plantas</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <?php
            if($_SESSION["perfilSesion"]==9)
            {
             echo '<div class="card-header">
                      <div class="row">   
                        <div class="col-4" >
                          <a class="btn btn-app" data-toggle="modal" data-target="#modalAgregarPlanta"  title="Crear planta" href="#">
                                  <i class="fas fas fa-industry"></i> Nueva planta
                            </a>
                        </div> 
                      </div> 
                  </div>';
            }
            ?>
            <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-striped table-bordered tablas" id="example_table" style="width:100%">
                    <thead>
                     <tr>
                      <th></th>
                      <th>EDITAR</th>
                      <th>PRODUCCION</th>
                      <th>NOMBRE</th>
                      <th>UBICACION</th>
                      <th>FECHA REGISTRO</th>
                      <th>TIPO INSTALACION</th>
                      <th>MUNICIPIO/DPTO</th>
                      <th>ACTIVIDAD</th>
                      <th>GERENTE</th>
                      <th>CONTACTO</th>
                      <th>EMAIL</th>
                      <th>JEFE MAN</th>
                      <th>CONTACTO</th>
                      <th>EMAIL</th>
                      </tr> 
                    </thead>
                    <tbody>
                        <?php

                  
                    if($_SESSION["proyecto_user"] <> 0)
                    {
                      $item = "idproyecto";
                      $valor = $_SESSION["proyecto_user"];
                    
                    }
                    else
                    {
                      $item = null;
                      $valor = null;
                    }
                    
                    $items = ControladorProyectos::ctrMostrarProyectos($item, $valor);

                      foreach ($items as $key => $value)
                      {
                        

                        echo ' <tr> 		                  
                                  
                                    <td class=" details-control" vlr="'.$value["idproyecto"].'"></td>
                                    <td>
                                      <div class="btn-group">
                                        <button class="btn btn-warning btnEditarProyectos" onclick="editProyecto(\''.$value["idproyecto"].'\',\''.$value['nombrePlanta'].'\')"    data-toggle="modal" data-target="#modalEditarProyecto"><i class="far fa-edit"></i></button>
                                      </div>  
                                    </td>
                                    <td>
                                      <div class="btn-group">
                                        <button class="btn btn-warning btnInsertProduccion" onclick="insertProduccion('.$value["idproyecto"].',\''.$value['nombrePlanta'].'\')"   data-toggle="modal" data-target="#modalInsertProduccion"><i class="fas fa-people-carry"></i></button>
                                      </div>  
                                    </td>
                                    <td>'.$value["nombrePlanta"].'</td> 
                                    <td>'.$value["ubicacionProyecto"].'</td> 
                                    <td>'.$value["fechaRegistro"].'</td> 
                                    <td>'.$value["tipoInstalacion"].'</td> 
                                    <td>'.$value["nombreMunicipio"].'/'.$value["departamento"].'</td> 
                                    <td>'.$value["actividadComercial"].'</td> 
                                    <td>'.$value["gerentePlanta"].'</td> 
                                    <td>'.$value["nroContacto"].'</td> 
                                    <td>'.$value["correoContacto"].'</td> 
                                    <td>'.$value["jefeMantenimiento"].'</td> 
                                    <td>'.$value["contactoJefe"].'</td> 
                                    <td>'.$value["correoContactojefe"].'</td> 
                                </tr>';
                        }


                   ?> 

                    </tbody>
                      <tfoot>
                        <tr>
                          <th></th>
                          <th>EDITAR</th>
                          <th>PRODUCCION</th>
                          <th>NOMBRE</th>
                          <th>UBICACION</th>
                          <th>FECHA REGISTRO</th>
                          <th>TIPO INSTALACION</th>
                          <th>MUNICIPIO/DPTO</th>
                          <th>ACTIVIDAD</th>
                          <th>GERENTE</th>
                          <th>CONTACTO</th>
                          <th>EMAIL</th>
                          <th>JEFE MAN</th>
                          <th>CONTACTO</th>
                          <th>EMAIL</th>
                        
                        </tr> 
                      </tfoot>
                </table>
              </div>
        </div>        
      </div>
    </div>
  </section>
</div>
<!--=====================================
MODAL AGREGAR PLANTA
======================================-->
<div id="modalAgregarPlanta" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
         
                  <div class="col-4">
                      <h4 class="modal-title"><i class="fas fa-industry"></i></h4>
                  </div>
                  <div class="col-4">
                     <label>Agregar planta</label>
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
            <div class="row">
             <div class="col-sm-12"> 
               <div class="form-group">
                 <div class="input-group">
                   <input type="text" class="form-control" name="nombrePlanta" id="nombrePlanta" placeholder="Nombre planta" required>
                 </div>
               </div>
              </div>
            </div>  
           <!-- ENTRADA PARA LA UBICACION -->
           <div class="row">
             <div class="col-sm-12"> 
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control" name="ubicacionProyecto" id="ubicacionProyecto" placeholder="Ubicacion proyecto" required>
                  </div>
                </div>
             </div>  
            </div>    
              <!-- ENTRADA PARA LA FECHA REGISTRO -->
           <div class="row">
             <div class="col-sm-6"> 
                  <div class="form-group">
                    <div class="input-group">
                        <input type="date" class="form-control" name="fechaRegistro" id="fechaRegistro" placeholder="Ingresar fecha registro" required>
                    </div>
                  </div>
             </div>     
            <!-- ENTRADA PARA LA TIPO INSTALACION -->
             <div class="col-sm-6">      
                  <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" name="tipoInstalacion" id="tipoInstalacion" placeholder="Ingresar tipo instalacion" required>
                    </div>
                  </div>
             </div>
           </div>       
            <!-- ENTRADA PARA EL PAIS -->
            <div class="row">
                <div class="col-sm-4"> 
                    <div class="form-group">
                        <div class="input-group">
                            <select class="form-control select2" name="pais" id="pais" title="pais" onChange="selectDpto(this.value,'nombreDepartamento')"  >
                              <option value="" >Pais...</option>
                            </select>  
                        </div>
                    </div>
                </div> 
              <!-- ENTRADA PARA EL DPTO -->
              <div class="col-sm-4">  
                    <div class="form-group">
                      <div class="input-group">
                          <select class="form-control select2" name="nombreDepartamento" id="nombreDepartamento" title="departamento" onChange="selectMunicipio(this.value,'nombreMunicipio')"  >
                            <option value="" >Departamento...</option>
                          </select>
                      </div>
                    </div>
              </div>  
              <!-- ENTRADA PARA EL MUNICIPIO -->
              <div class="col-sm-4"> 
                    <div class="form-group">
                      <div class="input-group">
                          <select class="form-control select2" name="nombreMunicipio" id="nombreMunicipio" title="municipio"  required>
                            <option value="" >Municipio...</option>
                          </select>  
                      </div>
                    </div>
                </div>
           </div>   
           <!-- ENTRADA PARA EL ACTIVIDAD COMERCIAL -->
           <div class="row">
              <div class="col-sm-12"> 
                <div class="form-group">
                  <div class="input-group">
                      <input type="text" class="form-control" name="actividadComercial" id="actividadComercial" placeholder="Actividad comercial" required>
                  </div>
                </div>
              </div>  
           </div>     
             <!-- ENTRADA PARA EL GERENTE PLANTA -->
             <div class="row">
               <div class="col-sm-6"> 
                  <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" name="gerentePlanta" id="gerentePlanta" placeholder="Gerente planta" required>
                    </div>
                  </div>
               </div>  
           <!-- ENTRADA PARA EL GERENTE NR CONTACTO -->
               <div class="col-sm-6"> 
                  <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" name="nroContacto" id="nroContacto" placeholder="# Contacto gerente" required>
                    </div>
                 </div>
               </div>
             </div>   
           <!-- ENTRADA PARA EL GERENTE EMAIL -->
           <div class="row">
              <div class="col-sm-12"> 
                <div class="form-group">
                    <div class="input-group">
                        <input type="email" class="form-control" name="correoContacto" id="correoContacto" placeholder="Correo gerente" required>
                    </div>
                </div>
              </div>  
           </div> 
            <div class="row">
            <!-- ENTRADA PARA EL JEFE PLANTA -->
                <div class="col-sm-6"> 
                    <div class="form-group">
                      <div class="input-group">
                          <input type="text" class="form-control" name="jefeMantenimiento" id="jefeMantenimiento" placeholder="Jefe planta" required>
                      </div>
                    </div>
                </div>   
                <!-- ENTRADA PARA EL JEFE NR CONTACTO -->
                <div class="col-sm-6"> 
                    <div class="form-group">
                      <div class="input-group">
                        <input type="text" class="form-control" name="contactoJefe" id="contactoJefe" placeholder="# Contacto jefe" required>
                      </div>
                  </div>
                </div>   
            </div>    
           <!-- ENTRADA PARA EL JEFE EMAIL -->
           <div class="row">
              <div class="col-sm-12"> 
               <div class="form-group">
                 <div class="input-group">
                    <input type="email" class="form-control" name="correoContactojefe" id="correoContactojefe" placeholder="Correo contacto jefe" required>
                 </div>
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
          $crearProyecto = new ControladorProyectos();
          $crearProyecto -> ctrCrearProyectos();
        ?>
      </form>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR Proyectos
======================================-->

<div id="modalEditarProyecto" class="modal fade" role="dialog">
  <div class="modal-dialog">
   <div class="modal-content">
      <form role="form" method="post">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
         
                  <div class="col-2">
                      <h4 class="modal-title"><i class="fas fa-car-battery" ></i></h4>
                  </div>
                  <div class="col-8">
                     <label id="lbl_proyecto_anuncio">  </label>
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
            <div class="row">
              <div class="col-sm-12"> 
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control"  name="nombrePlantaE" id="nombrePlantaE" placeholder="Ingresar nombre planta" required>
                    <input type="hidden"  name="idproyectoE" id="idproyectoE" value="">
                  </div>
                </div>
              </div>  
            </div>    
             <!-- ENTRADA PARA EL UBICACION -->
            <div class="row">
              <div class="col-sm-12">  
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control"  name="ubicacionProyectoE" id="ubicacionProyectoE" placeholder="Ingresar ubicacion proyecto" required>
                  </div>
                </div>
              </div>  
            </div>    
            <div class="row">
                <div class="col-sm-6"> 
                    <div class="form-group">
                        <div class="input-group">
                          <input type="text" class="form-control" name="fechaRegistroE"  id="fechaRegistroE" placeholder="Ingresar fecha" required>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6"> 
                    <div class="form-group">
                        <div class="input-group">              
                          <input type="text" class="form-control" name="tipoInstalacionE"  id="tipoInstalacionE" placeholder="Ingresar tipo" required>
                        </div>
                    </div>
                </div>
            </div>      
            <!-- ENTRADA PARA EL PAIS -->
            <div class="row">
              <div class="col-sm-4"> 
                    <div class="form-group">
                        <div class="input-group">
                            <select class="form-control select2" name="paisE" id="paisE" title="pais" onChange="selectDptoE(this.value,'nombreDepartamentoE',callback,'0')"  >
                              <option value="" >Pais...</option>
                            </select>  
                        </div>
                    </div>
              </div> 
              <!-- ENTRADA PARA EL DPTO -->
              <div class="col-sm-4">  
                    <div class="form-group">
                      <div class="input-group">
                          <select class="form-control select2" name="nombreDepartamentoE" id="nombreDepartamentoE" title="departamento" onChange="selectMunicipioE(this.value,'nombreMunicipioE',callback,'0')"  >
                            <option value="" >Departamento...</option>
                          </select>
                      </div>
                    </div>
              </div>  
              <!-- ENTRADA PARA EL MUNICIPIO -->
              <div class="col-sm-4"> 
                    <div class="form-group">
                      <div class="input-group">
                          <select class="form-control select2" name="nombreMunicipioE" id="nombreMunicipioE" title="municipio"  required>
                            <option value="" >Municipio...</option>
                          </select>  
                      </div>
                    </div>
              </div>
           </div>    
           <!-- ENTRADA PARA EL ACTIVIDAD COMERCIAL -->
           <div class="row">
              <div class="col-sm-12"> 
                  <div class="form-group">
                      <div class="input-group">              
                        <input type="text" class="form-control" name="actividadComercialE"  id="actividadComercialE" placeholder="Actividad comercial" required>
                      </div>
                  </div>
              </div>
           </div>          
           <!-- ENTRADA PARA EL GERENTE PLANTA -->
           <div class="row">
                <div class="col-sm-6"> 
                  <div class="form-group">
                    <div class="input-group">              
                      <input type="text" class="form-control" name="gerentePlantaE"  id="gerentePlantaE" placeholder="Gerente planta" required>
                    </div>
                  </div>
                </div>  
                  <!-- ENTRADA PARA EL GERENTE CONTACTO -->
                <div class="col-sm-6">  
                  <div class="form-group">
                    <div class="input-group">              
                      <input type="text" class="form-control" name="nroContactoE"  id="nroContactoE" placeholder="Contacto gerente planta" required>
                    </div>
                  </div>
                </div>
           </div>        
                  <!-- ENTRADA PARA EL GERENTE CORREO -->
          <div class="row">
              <div class="col-sm-12">         
                  <div class="form-group">
                    <div class="input-group">              
                      <input type="email" class="form-control" name="correoContactoE"  id="correoContactoE" placeholder="Correo Gerente planta" required>
                    </div>
                  </div>
              </div>    
          </div>
            <!-- ENTRADA PARA EL JEFE PLANTA -->
          <div class="row">
             <div class="col-sm-6">   
                  <div class="form-group">
                    <div class="input-group">              
                        <input type="text" class="form-control" name="jefeMantenimientoE"  id="jefeMantenimientoE" placeholder="Jefe planta" required>
                    </div>
                  </div>
              </div>    
              <!-- ENTRADA PARA EL JEFE CONTACTO -->
             <div class="col-sm-6"> 
                  <div class="form-group">
                    <div class="input-group">              
                      <input type="text" class="form-control" name="contactoJefeE"  id="contactoJefeE" placeholder="Contacto jefe planta" required>
                    </div>
                  </div>
              </div>
          </div>         
             <!-- ENTRADA PARA EL JEFE CORREO -->
          <div class="row">
            <div class="col-sm-12">       
                <div class="form-group">
                    <div class="input-group">              
                      <input type="text" class="form-control" name="correoContactojefeE"  id="correoContactojefeE" placeholder="Correo Jefe planta" required>
                    </div>
                 </div>
            </div>
          </div>       
           <input type="hidden" name="fuentes_energia" id="fuentes_energia" value="" />
            <!-- ENTRADA PARA EL JEFE CORREO -->
           <?php    
                $item = null;
                $valor = null;
                $i=3;
                $items = ControladorFuentes::ctrMostrarFuentes($item, $valor);
               
                foreach ($items as $key => $value)
                {
		              if($i%3 == 0)
                   {
                    echo '<div class="row">';
                   }           
                  
                  
                      echo '<div class="col-sm-4">   
                             <div class="form-group">
                               <div class="form-check">
                                 <input class="form-check-input" type="checkbox" name="fenergia[]" value="'.$value["idfuenteEnergia"].'">
                                 <label class="form-check-label">'.$value["nombreFuente"].'</label>
                               </div>
                             </div>
                           </div>';
             
                   
                   $i++;
                  if($i%3 == 0)
                    {
                      echo '</div>';
                    }  
                  
                }    
                echo '</div>';
                    
		        
              ?> 
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
          $editarProyectos = new ControladorProyectos();
          $editarProyectos -> ctrEditarProyectos();
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
<!-------------------------------------------------------------------------------------------------------------------->
<div id="modalIngresarConsumo" class="modal fade" role="dialog">
  <div class="modal-dialog">
   <div class="modal-content">
      <form role="form" method="post">
      <input type="hidden" name="proyecto_idproyecto_consumo" id="proyecto_idproyecto_consumo" value="" />
      <input type="hidden" name="fuenteEnergia_idfuenteEnergia_consumo" id="fuenteEnergia_idfuenteEnergia_consumo" value="" />    
       <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
         
                  <div class="col-4">
                      <h4 class="modal-title"><i class="fas fa-industry"></i></h4>
                  </div>
                  <div class="col-4">
                     <!-- <label>Agregar consumo</label> -->
                     <label id="nombrePlantaProduccionConsumo"></label>
                  </div>
                  <div class="col-4">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>        
      
        </div>
        <div class="modal-body">
          <div class="box-body">
        
          <div class="row">
           
            <div class="col-sm-6">
                <div class="form-group">
                  <div class="input-group">
                      <select class="form-control select2" id="anyo" name="anyo" title="año de consumo" required>
                      <option value="">Año de consumo..</option>
                            <?php

                            $anyo_int=2015;
                            $anyo_out=2030;
                            for($i=$anyo_int;$i<=$anyo_out;$i++)
                            {
                              echo '<option value="'.$i.'">'.$i.'  </option>';
                            }
                                

                            ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                  <div class="input-group">
                      <select class="form-control select2" id="mes" name="mes" title="mes de consumo" required>
                          <option value="">Mes de consumo...</option>
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
            </div>
          </div>
          <div class="row">
           
           <div class="col-sm-4">
               <div class="form-group">
                 <div class="input-group">
                 <input type="text" class="form-control" name="consumo" id="consumo" placeholder="Consumo" required>
               </div>
             </div>
           </div>
           <div class="col-sm-4">
               <div class="form-group">
                 <div class="input-group">
                 <input type="text" class="form-control" name="costo" id="costo" placeholder="$ Costo" required>
               </div>
             </div>
           </div>
           <div class="col-sm-4">
               <div class="form-group">
                 <div class="input-group">
                   <input type="text" class="form-control" name="indicador" id="indicador" placeholder="Indicador" required>
                 </div>
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
          $crearConsumo = new ControladorProyectos();
          $crearConsumo -> ctrCrearConsumo();
        ?> 
      </form>

   </div>
  </div>
 </div>
      <!-------------------------------------------------------------------------------------------------------------------->
<!--------------------------------PRODUCCION------------------------------------------------------------------------------------>
<div id="modalInsertProduccion" class="modal fade" role="dialog">
  <div class="modal-dialog">
   <div class="modal-content">
      <form role="form" method="post">
      <input type="hidden" name="proyecto_idproyecto_produccion" id="proyecto_idproyecto_produccion" value="" />
       <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
         
                  <div class="col-4">
                      <h4 class="modal-title"><i class="fas fa-industry"></i></h4>
                  </div>
                  <div class="col-4">
                     <label id="nombrePlantaProduccion"></label>
                  </div>
                  <div class="col-4">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>        
      
        </div>
        <div class="modal-body">
          <div class="box-body">
        
          <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                  <div class="input-group">
                      <select class="form-control select2" id="anyo_produccion" name="anyo_produccion" title="año de produccion" required>
                         <option value="">Año de produccion..</option>
                            <?php

                                $anyo_int=2015;
                                $anyo_out=2030;
                                for($i=$anyo_int;$i<=$anyo_out;$i++)
                                {
                                  echo '<option value="'.$i.'">'.$i.'  </option>';
                                }
                            ?>
                      </select>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                  <div class="input-group">
                      <select class="form-control select2" id="mes_produccion" name="mes_produccion" title="mes de produccion" required>
                          <option value="">Mes de produccion...</option>
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
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
               <div class="form-group">
                 <div class="input-group">
                 <input type="text" class="form-control" name="toneladas" id="toneladas" placeholder="Toneladas" required>
               </div>
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
          $crearProduccion = new ControladorProduccion();
          $crearProduccion -> ctrCrearProduccion();
        ?> 
      </form>

   </div>
  </div>
 </div>
  <!-------------------------------------------------------------------------------------------------------------------->



<form id="target_view" name="target_view" role="form" method="post" enctype="multipart/form-data" action="totales">
  <input type="hidden" name="proyecto_id" id="proyecto_id" value="">
  <input type="hidden" name="fuente_energia_id" id="fuente_energia_id" value="">
</form>
<form id="target_view_graficas" name="target_view" role="form" method="post" enctype="multipart/form-data" action="graficas">
  <input type="hidden" name="proyecto_id_grafica" id="proyecto_id_grafica" value="">
  <input type="hidden" name="fuenteEnergia_id_grafica" id="fuenteEnergia_id_grafica" value="">
</form>

</div>
