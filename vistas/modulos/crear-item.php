<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar items
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar items</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarItem">
          
          Agregar item

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>ID</th>
           <th>Descripción</th>
           <th>Tipo de respuesta</th>

         </tr> 

        </thead>

        <tbody>

        <?php

        $item = null;
        $valor = null;

        $items = ControladorItem::ctrMostrarItem($item, $valor);

       foreach ($items as $key => $value){
         
          echo ' <tr>
                  <td>'.$value["idItemPlantilla"].'</td>
                  <td>'.$value["descripcionItem"].'</td>
                  <td>
                    <div class="btn-group">
                        
                      <button class="btn btn-warning btnEditarItem" idItemPlantilla="'.$value["idItemPlantilla"].'" data-toggle="modal" data-target="#modalEditarItem"><i class="fa fa-pencil"></i></button>
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
MODAL AGREGAR ITEM
======================================-->

<div id="modalAgregarItem" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar item</h4>

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

                <input type="text" class="form-control input-lg" name="descripcionItem" placeholder="Ingresar item" required>

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
                                            <input type="checkbox" id="'.$value["tipoRespuesta"].'" name="'.$value["tipoRespuesta"].'" value="'.$value["idTipoRespuesta"].'">
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

          $crearItem = new ControladorItem();
          $crearItem -> ctrCrearItem();

        ?>

      </form>

    </div>

  </div>

</div>



