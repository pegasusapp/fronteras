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
            <h1>Lecturas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Home</a></li>
              <li class="breadcrumb-item active">Administrar lecturas</li>
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
                  <h3 class="card-title">Listado de lecturas</h3>     
                  </div>
               </div>
               <div class="row">   
                <div class="col-4">
                 </div>
                 <div class="col-4" >
                      <div class="icon-bar">
                        <a data-toggle="modal" data-target="#modalAgregarLectura"  id="iconAddUser"   title="Crear lectura" href="#"><em class="fas fa-file-invoice"></em></a> 
                      </div>
                 </div> 
                 <div class="col-4">
                 </div> 
                </div> 
           
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive tablas">
              <caption>Listado de lecturas de energia</caption>  
              <thead>
                <tr>
                  <th id="idlog">ID</th>
                  <th id="archivo_tag">ARCHIVO</th>
                  <th id="date_tag">FECHA</th>
                  <th id="estado_tag">ESTADO</th>
                  <th id="opciones_tag">OPCIONES</th>
                </tr> 
                </thead>
                <tbody>
                <?php
                $item = null;
                $valor = null;
                
                $items = ControladorLogLectura::ctrMostrarLogLectura($item, $valor); 
                foreach ($items as $key => $value)
                    {
                        echo ' <tr>
                                    <td>'.$value["idlogLecturas"].'</td>
                                    <td>'.$value["fechaInsert"].'</td>
                                    <td>'.$value["nameFile"].'</td>
                                    <td>'.$value["upload"].'</td>
                                    <td>
                                        <div class="btn-group">
                                          <button class="btn btn-primary px-2.5" onclick=deleteFile("'.$value["idlogLecturas"].'","'.$value["nameFile"].'")  data-toggle="modal"><em class="fas fa-trash-alt"></em></button>
                                          <button class="btn btn-primary px-2.5" onclick=insertFile("'.$value["idlogLecturas"].'")  data-toggle="modal"><em class="fas fa-upload"></em></button>
                                        </div> 
                                     </td>
                                </tr>';
                    }
                ?> 
                </tbody>
                <tfoot>
                <tr>
                  <th id="idlog">ID</th>
                  <th id="archivo_tag">ARCHIVO</th>
                  <th id="date_tag">FECHA</th>
                  <th id="estado_tag">ESTADO</th>
                  <th id="opciones_tag">OPCIONES</th>
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
  </section>
</div>

<!--=====================================
MODAL AGREGAR LECTURA
======================================-->
<div id="modalAgregarLectura" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form aria-label="Formulario de ingreso de lecturas" role="form" method="post" enctype="multipart/form-data">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header" style="background:#3c8dbc; color:white">
         
                  <div class="col-4">
                      <h4 class="modal-title"><em class="fas fa-user-plus" ></em></h4>
                  </div>
                  <div class="col-4">
                     <label>Agregar lecturas</label>
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
           <!-- ENTRADA PARA EL ARCHIVO -->
            <div class="form-group">
              <div class="input-group">
                  <input type="file" class="form-control" name="nameFile" id="nameFile" placeholder="Ingresar archivo" required>
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
          $crearLog = new ControladorLogLectura();
          $crearLog -> ctrCrearLogLectura();
        ?>
      </form>
    </div>
  </div>
</div> 

<form method="post" name="form_editMenu" id="form_editMenu" action="editMenu">    
    <input id="identificadorMenu" name="identificadorMenu" type="hidden" value="" />
</form>