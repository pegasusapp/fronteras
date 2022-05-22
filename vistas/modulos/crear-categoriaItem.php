<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar categorías Item
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar categprías Item</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCategoriaItem">
          
          Agregar categoría Item

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas">
         
        <thead>
         
         <tr>
           
          
           <th>NOMBRE</th>
           <th>ACCIÓN</th>

         </tr> 

        </thead>

        <tbody>

        <?php

        $item = null;
        $valor = null;

        $items = ControladorCategoriaItem::ctrMostrarCategoriaItem($item, $valor);

       foreach ($items as $key => $value){
         
          echo ' <tr>
                  
                
                  <td>'.$value["nombre"].'</td>
                  <td>
                    <div class="btn-group">
                        
                      <button class="btn btn-warning btnEditarCategoriaItem" idCategoriaItem="'.$value["idcategoria_item"].'" data-toggle="modal" data-target="#modalEditarCategoriaItem"><i class="fa fa-pencil"></i></button>
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
MODAL AGREGAR CATEGORIA
======================================-->

<div id="modalAgregarCategoriaItem" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar categoría item</h4>

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

                <input type="text" class="form-control input-lg" name="nombreCategoriaItem" id="nombreCategoriaItem" placeholder="Ingresar categoría" required>

              </div>

            </div>
           </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar categoría</button>

        </div>

        <?php

          $crearCategoriaItem = new ControladorCategoriaItem();
          $crearCategoriaItem -> ctrCrearCategoriaItem();

        ?>

      </form>

    </div>

  </div>

</div>
<!--=====================================
MODAL EDITAR CATEGORÍA
======================================-->

<div id="modalEditarCategoriaItem" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar categoría item</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <input type="text" class="form-control input-lg" name="editarCategoriaItem" id="editarCategoriaItem" required>

                 <input type="hidden"  name="idCategoriaItem" id="idCategoriaItem" required>

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

          $editarCategoriaItem = new ControladorCategoriaItem();
          $editarCategoriaItem -> ctrEditarCategoriaItem();

        ?> 

      </form>

    </div>

  </div>

</div>
