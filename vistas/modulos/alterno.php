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
              <li class="breadcrumb-item active">Administrar plantas alternas</li>
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
                  <h3 class="card-title">Listado de plantas alternas</h3>     
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
                      <!--  <a data-toggle="modal" data-target="#modalAgregarAlterno" id="iconAddUser"   title="Crear planta" href="#"><i class="fas fa-location-arrow"></i></a>&nbsp; 
                      <a href="#"><i class="fas fa-lock"></i></a> &nbsp;
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
                  <th>ID</th>
                  <th>EMPRESA</th>
                  <th>SEDE</th>
                  <th>FECHA</th>
                  <th>CIUDAD</th>
                  <th>DPTO</th>
                  <th>DIRECCION</th>
                  <th>CONTACTO</th>
                  <th>ACTIVO</th>
                  <th>OR</th>
                  <th>VLR ACTIVA</th>
                  <th>VLR FACTURA</th>
                  <th>VLR kWh</th>
                  <th>M1</th>
                  <th>M2</th>
                  <th>M3</th>
                  <th>M4</th>
                  <th>M5</th>
                  <th>M6</th>
                  <th>M7</th>
                  <th>M8</th>
                  <th>M9</th>
                  <th>M10</th>
                  <th>M11</th>
                  <th>M12</th>
                  <th>PROM MENSUAL</th>
                  <th>MERCADO</th>
                  <th>NIVEL TENSION</th>
                  <th>EDITAR</th>
                </tr> 
              </thead>
        <tbody>
        <?php
	       
	        $item = null;
	        $valor = null;
    		$items = ControladorAlterno::ctrMostrarAlterno($item, $valor);

		       foreach ($items as $key => $value)
		       {
		         
              echo ' <tr>
                        <td>'.$value["alternaempresa_id"].'</td> 
                        <td>'.$value["empresa"].'</td> 
                        <td>'.$value["sede"].'</td> 
                        <td>'.$value["fecha"].'</td> 
                        <td>'.$value["ciudad"].'</td> 
                        <td>'.$value["departamento"].'</td> 
                        <td>'.$value["direccion"].'</td> 
                        <td>'.$value["nrocontacto"].'</td> 
                        <td>'.$value["activo"].'</td> 
                        <td>'.$value["or"].'</td> 
                        <td>'.$value["vlr_activa"].'</td> 
                        <td>'.$value["vlr_factura"].'</td> 
                        <td>'.$value["vlr_kvh"].'</td> 
                        <td>'.$value["m1"].'</td> 
                        <td>'.$value["m2"].'</td> 
                        <td>'.$value["m3"].'</td> 
                        <td>'.$value["m4"].'</td> 
                        <td>'.$value["m5"].'</td> 
                        <td>'.$value["m6"].'</td> 
                        <td>'.$value["m7"].'</td> 
                        <td>'.$value["m8"].'</td> 
                        <td>'.$value["m9"].'</td> 
                        <td>'.$value["m10"].'</td> 
                        <td>'.$value["m11"].'</td> 
                        <td>'.$value["m12"].'</td> 
                        <td>'.$value["prom_mes"].'</td> 
                        <td>'.$value["mercado"].'</td>
                        <td>'.$value["niveltension"].'</td> 
		                  <td>
		                    <div class="btn-group">
		                      <button class="btn btn-warning btnEditarAlterno" onclick=editAlterno("'.$value["alternaempresa_id"].'")    data-toggle="modal" data-target="#modalEditarAlterno"><i class="far fa-edit"></i></button>
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
MODAL AGREGAR FUENTE
======================================-->
<div id="modalAgregarAlterno" class="modal fade" role="dialog">
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
                     <label>Agregar alterno</label>
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
                <input type="text" class="form-control" name="empresa" id="empresa" placeholder="Nombre empresa" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="sede" id="sede" placeholder="Sede" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="fecha" id="fecha" placeholder="Fecha" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="ciudad" id="ciudad" placeholder="Ciudad" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="departamento" id="departamento" placeholder="Dpto" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Direccion" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="nrocontacto" id="nrocontacto" placeholder="# contacto" required>
              </div>
            </div>
 
            <div class="form-group">
               <div class="input-group">
                 <select class="form-control input-lg" id="activo" name="activo" required>
                      <option value="SI" >SI</option> 
                      <option value="NO" >NO</option> 
               </select>
               </div>
            </div>

            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="or" id="or" placeholder="operador red" required>
              </div>
            </div>

             <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="vlr_activa" id="vlr_activa" placeholder="Valor activa" required>
              </div>
            </div>     

            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="vlr_factura" id="vlr_factura" placeholder="Valor factura" required>
              </div>
            </div>  

            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="vlr_kvh" id="vlr_kvh" placeholder="Valor kWH" required>
              </div>
            </div>  

           <div class="row">
            <div class="col-3">
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="m1" id="m1" placeholder="Mes 1" required>
              </div>
            </div> 
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="m2" id="m2" placeholder="Mes 2" required>
              </div>
            </div> 
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control" name="m3" id="m3" placeholder="Mes 3" required>
              </div>
            </div> 
            </div>
            <div class="col-3">
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
          $crearAlterno = new ControladorAlterno();
          $crearAlterno -> ctrCrearAlterno();
        ?>
      </form>
    </div>
  </div>
</div>

<!--=====================================
MODAL EDITAR AREA
======================================-->

<div id="modalEditarAlterno" class="modal fade" role="dialog">
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
                     <label id="lbl_proyecto_anuncio">Editar valores planta </label>
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


            <!-- ENTRADA PARA LA PLANTA -->
            <div class="row">
               <div class="col-sm-4"> 
                  <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="vlr_activae" id="vlr_activae" placeholder="Valor activa" required>
                    </div>
                  </div>
               </div>
               <div class="col-sm-4"> 
                 <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="vlr_facturae" id="vlr_facturae" placeholder="Valor factura" required>
                    </div>
                 </div>
               </div>
               <div class="col-sm-4"> 
                 <div class="form-group">
                    <div class="input-group">
                      <input type="text" class="form-control" name="vlr_kvhe" id="vlr_kvhe" placeholder="Valor kvh" required>
                    </div>
                 </div>
               </div>
            </div>  
          <!-- ENTRADA PARA LA FECHA REGISTRO -->
           <div class="row">
             <div class="col-sm-3"> 
                  <div class="form-group">
                    <div class="input-group">
                        <input type="number" class="form-control" name="m1e" id="m1e" placeholder="m1" required>
                    </div>
                  </div>
             </div>     
            <!-- ENTRADA PARA LA TIPO INSTALACION -->
             <div class="col-sm-3">      
                  <div class="form-group">
                    <div class="input-group">
                        <input type="number" class="form-control" name="m2e" id="m2e" placeholder="m2" required>
                    </div>
                  </div>
             </div>
             <div class="col-sm-3"> 
                  <div class="form-group">
                    <div class="input-group">
                        <input type="number" class="form-control" name="m3e" id="m3e" placeholder="m3"  required>
                    </div>
                  </div>
             </div>     
            <!-- ENTRADA PARA LA TIPO INSTALACION -->
             <div class="col-sm-3">      
                  <div class="form-group">
                    <div class="input-group">
                        <input type="number" class="form-control" name="m4e" id="m4e" placeholder="m4"  required>
                    </div>
                  </div>
             </div>
             <div class="col-sm-3"> 
                  <div class="form-group">
                    <div class="input-group">
                        <input type="number" class="form-control" name="m5e" id="m5e" placeholder="m5"  required>
                    </div>
                  </div>
             </div>     
            <!-- ENTRADA PARA LA TIPO INSTALACION -->
             <div class="col-sm-3">      
                  <div class="form-group">
                    <div class="input-group">
                        <input type="number" class="form-control" name="m6e" id="m6e" placeholder="m6"  required>
                    </div>
                  </div>
             </div>
             <div class="col-sm-3"> 
                  <div class="form-group">
                    <div class="input-group">
                        <input type="number" class="form-control" name="m7e" id="m7e" placeholder="m7"  required>
                    </div>
                  </div>
             </div>     
            <!-- ENTRADA PARA LA TIPO INSTALACION -->
             <div class="col-sm-3">      
                  <div class="form-group">
                    <div class="input-group">
                        <input type="number" class="form-control" name="m8e" id="m8e" placeholder="m8"  required>
                    </div>
                  </div>
             </div>
             <div class="col-sm-3"> 
                  <div class="form-group">
                    <div class="input-group">
                        <input type="number" class="form-control" name="m9e" id="m9e" placeholder="m9"  required>
                    </div>
                  </div>
             </div>     
            <!-- ENTRADA PARA LA TIPO INSTALACION -->
             <div class="col-sm-3">      
                  <div class="form-group">
                    <div class="input-group">
                        <input type="number" class="form-control" name="m10e" id="m10e" placeholder="m10"  required>
                    </div>
                  </div>
             </div>
             <div class="col-sm-3"> 
                  <div class="form-group">
                    <div class="input-group">
                        <input type="number" class="form-control" name="m11e" id="m11e" placeholder="m11"  required>
                    </div>
                  </div>
             </div>     
            <!-- ENTRADA PARA LA TIPO INSTALACION -->
             <div class="col-sm-3">      
                  <div class="form-group">
                    <div class="input-group">
                        <input type="number" class="form-control" name="m12e" id="m12e" placeholder="m12"   required>
                    </div>
                  </div>
             </div>
           </div>       
          <!-- ENTRADA PARA EL JEFE EMAIL -->
           <div class="row">
              <div class="col-sm-6"> 
               <div class="form-group">
                 <div class="input-group">
                    <input type="text" class="form-control" name="prom_mese" id="prom_mese" placeholder="Promedio mes" required>
                 </div>
               </div>
              </div>
              <div class="col-sm-6"> 
               <div class="form-group">
                 <div class="input-group">
                    <input type="text" class="form-control" name="mercadoe" id="mercadoe" placeholder="Mercado" >
                 </div>
               </div>
              </div>
           </div>        

           </div>
        </div>
        
        <input type="hidden" class="form-control" name="alternaempresa_ide" id="alternaempresa_ide"  value="" /> 

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      <?php 

          $editarAlterno = new ControladorAlterno();
          $editarAlterno -> ctrEditarAlterno();

        
        ?> 

      </form>

    </div>

  </div>

</div>
<?php 

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