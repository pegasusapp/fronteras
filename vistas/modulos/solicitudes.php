<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Resolución 030 - Autogeneración a pequeña escala</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Home</a></li>
              <li class="breadcrumb-item active">Solicitudes</li>
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
              <h3 class="card-title">Listado de solicitudes</h3>
            </div>
         <div class="card-body">
          <table  class="table table-bordered table-striped tablas" id="example2">
          <thead>
            <tr>
              <th>NIU</th>
              <th>NÚMERO SOLICITUD</th>
              <th>FECHA SOLICITUD</th>
              <th>ESTADO</th>
              <th>FECHA ULTIMA ACTUALIZACION</th>
              <th>GESTIONAR</th>
            </tr> 
          </thead>
          <tbody>
          <?php

             $item = null;
             $valor = null;
             $items = ControladorSolicitud::ctrMostrarSolicitud($item, $valor);
             foreach ($items as $key => $value)
              {
                echo ' <tr>
                  <td>'.$value["Usuario_niu"].'</td>
                  <td>'.$value["nro_solicitud"].'</td>
                  <td>'.$value["fecha_solicitud"].'</td>
                  <td>'.$value["nombre"].'</td>
                  <td>'.$value["fecha_actualizacion"].'</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-info btnVerItemSolicitud"  onclick=\'verSolicitud("'.$value["idsolicitudes"].'")\'  data-toggle="modal" data-target="#modalEditarPlantillaTrabajo2" title="Ver solicitud"><i class="fa fa-eye"></i></button>
                    </div>  
                  </td>
                </tr>';
              }

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

        </tbody>
        <tfoot>
        <tr>
           <th>NIU</th>
           <th>NÚMERO SOLICITUD</th>
           <th>FECHA SOLICITUD</th>
           <th>ESTADO</th>
           <th>FECHA ULTIMA ACTULIZACION</th>
           <th>GESTIONAR</th>
        </tr>
        </tfoot>
       </table>
     </div>
     <!-- /.card-body -->
     </div>
     </div>
     </div>
  </section>
      </div>



<!--=====================================
MODAL EDITAR SOLICITUD
======================================-->


<form id="target_view" name="target_view" role="form" method="post" enctype="multipart/form-data" action="mostrarSolicitud">
  <input type="hidden" name="solicitud_id" id="solicitud_id" value="">
  
</form>

