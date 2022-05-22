<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Crear documento de auditoria
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Crear documento de auditoria</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarDocumentoTrabajo">
          
          Agregar documento de auditoria

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas">
        <thead>
         <tr>
           <th style="width:150px">DESCRIPCION</th>
           <th>EMPRESA</th>
           <th>USUARIO</th>
 		       <th>PLANTILLA</th>
           <th>ESTADO</th>
 		       <th>ITEMS</th>
         </tr> 
        </thead>
        <tbody>
        <?php

        $item = null;
        $valor = null;

        $items = ControladorDocumentoTrabajo::ctrMostrarDocumentoTrabajo($item, $valor);

       foreach ($items as $key => $value){
         $res = ($value["estadoDocumento_idestadoDocumento"] == 1) ? "Activo" : "Inactivo";
          echo ' <tr>
                  
                  
                  <td>'.$value["descripcionDocumento"].'</td>
                  <td>'.$value["nombreEmpresa"].'</td>
                  <td>'.$value["nombreCompleto"].'</td>
                  <td>'.$value["nombrePlantilla"].'</td>
                  <td>'.$res.'</td>
                  <td>
                    <div class="btn-group">
                        
                      <button class="btn btn-warning btnEditarDocumentoTrabajo" idDocumentoTrabajo="'.$value["idDocumentoTrabajo"].'" data-toggle="modal" data-target="#modalEditarDocumentoTrabajo" title="Editar documento"><i class="fa fa-pencil"></i></button>
                    </div>
                     <button class="btn btn-success btnCrearItemDocumentoTrabajo" idDocumentoTrabajoI="'.$value["idDocumentoTrabajo"].'" data-toggle="modal" data-target="#modalAgregarItem" title="Agregar Item a este documento"><i class="fa fa-plus" ></i></button>
                      <button class="btn btn-info btnVerItemDocumentoTrabajo" idDocumentoTrabajoV="'.$value["idDocumentoTrabajo"].'" data-toggle="modal" data-target="#modalEditarDocumentoTrabajo2" title="Ver items de este documento"><i class="fa fa-eye"></i></button>
                 
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
MODAL AGREGAR DOCUMENTO
======================================-->

<div id="modalAgregarDocumentoTrabajo" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar plantilla trabajo</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
             	  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-comment"></i></span> 
		                <textarea class="form-control input-lg" name="descripcionDocumento" id="descripcionDocumento" placeholder="Descripción del documento" required></textarea>  
            	  </div>
            </div>	  
            <div class="form-group">
           		 <div class="input-group">
              			<span class="input-group-addon"><i class="fa fa-building"></i></span> 
               			<select class="form-control input-lg" id="EmpresaCliente_idEmpresaCliente" name="EmpresaCliente_idEmpresaCliente" required>
               				<option value="" >Seleccione la empresa...</option> 
              			 <?php

					        $item  = null;
					        $valor = null;

					        $items = ControladorEmpresaCliente::ctrMostrarEmpresaCliente($item, $valor);

					       foreach ($items as $key => $value)
					       {
					         
					         echo '<option value="'.$value["idEmpresaCliente"].'">'.$value["nombreEmpresa"].'  </option>';
					                  
					                  
					       }


							?> 

              		    </select>
				
             	 </div>
            </div> 
            <div class="form-group">
              
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-user"></i></span> 
                    <select class="form-control input-lg" id="Usuario_niu" name="Usuario_niu" required>
                      <option value="" >Seleccione el usuario encargado...</option>
                     <?php

                  $item  = null;
                  $valor = null;

                  $items = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

                 foreach ($items as $key => $value)
                 {
                   
                   echo '<option value="'.$value["niu"].'">'.$value["nombreCompleto"].'  </option>';
                            
                            
                 }


              ?> 

                      </select>
        
               </div>
            </div>    
           <div class="form-group">
               <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-check"></i></span> 
                    <select class="form-control input-lg" id="PlantillaTrabajo_idPlantillaTrabajo" name="PlantillaTrabajo_idPlantillaTrabajo" required>
                      <option value="" >Seleccione la plantilla...</option>
                     <?php

                          $item  = null;
                          $valor = null;

                          $items = ControladorPlantillaTrabajo::ctrMostrarPlantillaTrabajo($item, $valor);
                         foreach ($items as $key => $value)
                           {
                           
                             echo '<option value="'.$value["idPlantillaTrabajo"].'">'.$value["nombrePlantilla"].'  </option>';
                                    
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

          <button type="submit" class="btn btn-primary">Guardar plantilla</button>

        </div>

        <?php

          $crearDocumentoTrabajo = new ControladorDocumentoTrabajo();
          $crearDocumentoTrabajo -> ctrCrearDocumentoTrabajo();

        ?>

      </form>

    </div>

  </div>

</div>
<!--=====================================
MODAL EDITAR DOCUMENTO
======================================-->

<div id="modalEditarDocumentoTrabajo" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar documento</h4>

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

                <input type="text" class="form-control input-lg" name="editarDocumentoTrabajo" id="editarDocumentoTrabajo" required>


                 <input type="hidden"  name="idDocumentoTrabajo" id="idDocumentoTrabajo" required>

              </div>

            </div>
           <div class="form-group">

           		 <div class="input-group">
              			<span class="input-group-addon"><i class="fa fa-file"></i></span> 
               			<select class="form-control input-lg" id="editarCategoriaPlantilla_idCategoriaPlantilla" name="editarCategoriaPlantilla_idCategoriaPlantilla" required>
               				<option value="" >Seleccione la categoría...</option>
              			 <?php

					        $item  = null;
					        $valor = null;

					        $items = ControladorCategoria::ctrMostrarCategoria($item, $valor);

					       foreach ($items as $key => $value)
					       {
					         
					         echo '<option value="'.$value["idCategoriaPlantilla"].'">'.$value["nombreCategoriaPlantilla"].'  </option>';
					                  
					                  
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

          $editarDocumentoTrabajo = new ControladorDocumentoTrabajo();
          $editarDocumentoTrabajo -> ctrEditarDocumentoTrabajo();

        ?> 

      </form>

    </div> 

  </div>

</div>
<form id="target_view" name="target_view" role="form" method="post" enctype="multipart/form-data" action="mostrar-item-documento">
  <input type="hidden" name="documentoitem_id" id="documentoitem_id" value="">
  
</form>
