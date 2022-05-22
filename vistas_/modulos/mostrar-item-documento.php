<div class="content-wrapper">

  <section class="content-header">
    
    <h1>Listado items del documento 
        <?php
                                        if(!isset($_POST["documentoitem_id"]))
                                        {
                                          echo '<script>

                                                 window.location = "crear-documento";

                                                </script>';
                                        }
                                        else
                                        {
                                           $item = "idDocumentoTrabajo";
                                           $valor = $_POST["documentoitem_id"];
                                           $items = ControladorDocumentoTrabajo::ctrMostrarDocumentoTrabajo($item, $valor);
                                           echo '"'.$items["descripcionDocumento"].'"';
                                          
                                        }
                                       
                                      ?> 
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar items</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  

        <button class="btn btn-primary btnAtrascrearDocumento" data-toggle="modal" data-target="#modalAgregarDocumentoTrabajo">
          
         Atras

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas">
         
        <thead>
         
         <tr>
         
           <th style="width:350px">DESCRIPCIÓN</th>
           <th>TIPOS DE RTA</th>
 		       <th>ACCIONES</th>
         </tr> 

        </thead>

        <tbody>

        <?php

        $item = "DocumentoTrabajo_idDocumentoTrabajo";
        $valor = $_POST["documentoitem_id"];

        $items = ControladorItemDocumentoTrabajo::ctrMostrarItemDocumentoTrabajo($item, $valor);


       foreach ($items as $key => $value){
         
          echo ' <tr>
                  
                
                  <td>'.$value["descripcionItem"].'</td>
                  <td>'.$value["respuestas"].'</td>
                  <td>
                    <div class="btn-group">
                        
                      <button class="btn btn-warning btnEditarItemDocumentoTrabajo" idEditaritemDocumento="'.$value["idItemPlantilla"].'" data-toggle="modal" data-target="#modalEditarItemDocumento" title="Editar item"><i class="fa fa-pencil"></i></button>
                    </div>
                     <div class="btn-group">
                      <button class="btn btn-info btnVerItemDocumentoTrabajo" idItemDocumento="'.$value["idItemPlantilla"].'" data-toggle="modal" data-target="#modalEditarDocumentoTrabajo" title="Ver definitivo"><i class="fa fa-eye"></i></button>
                    </div>
                      <div class="btn-group">
                      <button class="btn btn-danger btnEliminarItemDocumentoTrabajo" idItemDocumento="'.$value["idItemPlantilla"].'" data-toggle="modal" data-target="#modalEditarDocumentoTrabajo" title="Eliminar item"><i class="fa fa-trash-o"></i></button>
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
MODAL EDITAR ITEM
======================================-->

<div id="modalEditarItemDocumento" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">
      <input type="hidden" name="documentoitem_id" id="documentoitem_id" value='<?php echo $_POST["documentoitem_id"]?>'>

      <input type="hidden" name="edicion_opciones_eleccion" id="edicion_opciones_eleccion" value=''>
      <input type="hidden" name="edicion_opciones_puntaje" id="edicion_opciones_puntaje" value=''>

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar item</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-file"></i></span> 

                <input type="text" class="form-control input-lg" name="descripcionItem" id="descripcionItem"  required>
                <input type="hidden" name="idEdicionItemDocumento" id="idEdicionItemDocumento"  value="" />
              </div>

            </div>
          
            <!-- TIPOS DE RESPUESTA -->
            <div class="box-header with-border">
              <h3 class="box-title">Tipos de respuesta</h3>
            </div>
              <div class="form-group">
           
                   <?php

                        $item = null;
                        $valor = null;

                        $items = ControladortipoRespuesta::ctrMostrartipoRespuesta($item, $valor);

                       foreach ($items as $key => $value)
                           {
                                  echo '<div class="checkbox">
                                        <label>
                                            <input type="checkbox"  name="TipoRespuesta[]" value="'.$value["sigla"].'">
                                                        '.$value["tipoRespuesta"].'
                                        </label>
                                        </div>';
                           }
                       ?>
                       
              </div>

              <!-- RESPUESTAS -->
            <div class="box-header with-border">
              <h3 class="box-title">Construcción de tipos de respuesta</h3>
            </div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                </ul>
                  <div class="tab-content" id="myTabContent">
                  </div>
             <!-- fin respuestas -->


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

          $EditarItemDocumentoTrabajo = new ControladorItemDocumentoTrabajo();
          $EditarItemDocumentoTrabajo -> ctrEditarItemDocumentoTrabajo();

        ?>

      </form>

    </div>

  </div>

</div>
