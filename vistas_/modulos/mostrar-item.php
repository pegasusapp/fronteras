<div class="content-wrapper">

  <section class="content-header">
    
    <h1>Listado items de la Plantilla 
        <?php
                                        if(!isset($_POST["plantillaitem_id"]))
                                        {
                                          echo '<script>

                                                 window.location = "crear-plantilla";

                                                </script>';
                                        }
                                        else
                                        {
                                           $item = "idPlantillaTrabajo";
                                           $valor = $_POST["plantillaitem_id"];
                                           $items = ControladorPlantillaTrabajo::ctrMostrarPlantillaTrabajo($item, $valor);
                                           echo '"'.$items["nombrePlantilla"].'"';
                                          
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
  

        <button class="btn btn-primary btnAtrascrearPlantilla" data-toggle="modal" data-target="#modalAgregarPlantillaTrabajo">
          
         Atras

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas">
         
        <thead>
         
         <tr>
         
           <th style="width:150px">DESCRIPCIÓN</th>
           <th>PLANTILLA RELACIONADA</th>
           <th>TIPOS DE RTA</th>
 		       <th>ACCIONES</th>
         </tr> 

        </thead>

        <tbody>

        <?php

        $item = "idPlantillaTrabajo";
        $valor = $_POST["plantillaitem_id"];

        $items = ControladorItemPlantillaTrabajo::ctrMostrarItemPlantillaTrabajo($item, $valor);


       foreach ($items as $key => $value){
         
          echo ' <tr>
                  
                
                  <td>'.$value["descripcionItem"].'</td>
                  <td>'.$value["nombrePlantilla"].'</td>
                  <td>'.$value["respuestas"].'</td>
                  <td>
                    <div class="btn-group">
                        
                      <button class="btn btn-warning btnEditarItemPlantillaTrabajo" idEditaritemPlantilla="'.$value["idItemPlantilla"].'" data-toggle="modal" data-target="#modalEditarItem" title="Editar item"><i class="fa fa-pencil"></i></button>
                    </div>
                      <button class="btn btn-info btnVerItemPlantillaTrabajo" idItemPlantilla="'.$value["idItemPlantilla"].'" data-toggle="modal" data-target="#modalEditarPlantillaTrabajo" title="Ver mas detalles"><i class="fa fa-eye"></i></button>
                 

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

<div id="modalEditarItem" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">
      <input type="hidden" name="plantillaitem_id" id="plantillaitem_id" value='<?php echo $_POST["plantillaitem_id"]?>'>
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

                <input type="text" class="form-control input-lg" name="descripcionItem" id="descripcionItem" placeholder="Ingresar item" required>
                <input type="hidden" name="idEdicionItemPlantilla" id="idEdicionItemPlantilla"  value="" />
              </div>

            </div>

           

            
            <!-- ENTRADA PARA SELECCIONAR SU PERFIL -->
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
                                            <input type="checkbox"  name="TipoRespuesta[]" value="'.$value["idTipoRespuesta"].'">
                                                        '.$value["tipoRespuesta"].'
                                        </label>
                                        </div>';
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

          $EditarItemPlantillaTrabajo = new ControladorItemPlantillaTrabajo();
          $EditarItemPlantillaTrabajo -> ctrEditarItemPlantillaTrabajo();

        ?>

      </form>

    </div>

  </div>

</div>
