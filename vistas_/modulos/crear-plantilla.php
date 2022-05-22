<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar plantillas
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar plantillas</li>
    
    </ol>

    </section>

  	<section class="content">
					    <!--
					    <div class="row"> 
							    <div class="col-md-5">
							  		<div class="box box-info">
							            <div class="box-header with-border">
							              <h3 class="box-title">Agregar plantillas</h3>
							            </div>
							          
							            <form class="form-horizontal"> 
							                <div class="box-body">
								                <div class="form-group">
								                  <label for="inputEmail3" class="col-sm-2 control-label">Nombre</label>
								                  <div class="col-sm-10">
								                   <input type="text" class="form-control" name="nombrePlantilla" id="nombrePlantilla" placeholder="Ingresar nombre plantilla" required>
								                  </div>
								                </div>
                               <div class="form-group">
                                  <label for="inputPassword3" class="col-sm-2 control-label">Adjuntar Secciones</label>
                                    <div class="col-sm-10">
                                       <div class="input-group">
                                          <div class="input-group-btn">
                                            <button type="button" class="btn btn-success" onclick="addSeccion();"><i class="fa fa-plus"></i></button>
                                          </div>
                                          <input type="text" class="form-control" name="nombreSeccion" id="nombreSeccion" placeholder="Ingresar nombre de la seccion" required>
                                        </div>

                                    </div>
                                </div> 
								                <div class="form-group">
								                  <label for="inputPassword3" class="col-sm-2 control-label">Secciones</label>

								                  <div class="col-sm-10"> 

                                      <div class="input-group">
                                        <div class="input-group-btn">
                                          <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action<span class="fa fa-caret-down"></span></button>
                                          <ul class="dropdown-menu">
                                              <li><a href="#" onClick="deleteSeccion();">Borrar</a></li>
                                              <li><a href="#" onClick="editSeccion();">Editar</a></li>
                                              <li class="divider"></li>
                                              <li><a href="#" onClick="resetSelect();">Borrar todo</a></li>
                                             </ul>
                                        </div>
                                       <select class="form-control" id="idsecciones"  name="idsecciones[]" >  <option value="" >Secciones de la plantilla...</option> </select>
                                      </div>

								              
                                       
                                  
								                  </div>
								                </div>
								                
                                   
                                
              


								                <div class="form-group">
								                  <label for="inputPassword3" class="col-sm-2 control-label">Categor&iacute;a</label>

								                  <div class="col-sm-10">
								                    <input class="form-control" id="inputPassword3" placeholder="Password" type="password">
								                  </div>
								                </div>
								               
							                </div>
								            <div class="box-footer">
								                <button type="submit" class="btn btn-default">Cancelar</button>
								                <button type="submit" class="btn btn-info pull-right">Guardar</button>
								            </div>
								              
							            </form>
							        </div>
							    </div>
					    </div> 
 							-->
					    <div class="row">
					        <div class="col-xs-12">
							    <div class="box">
							            <div class="box-header with-border">
							             <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarPlantillaTrabajo" onclick="resetSelect();">
							                  Agregar plantilla
							              </button> -->
							              <a class="btn btn-app" data-toggle="modal" data-target="#modalAgregarPlantillaTrabajo" onclick="resetSelect();" >
                								<i class="fa fa-file-code-o"></i> Nueva plantilla
            							  </a>
							              <a class="btn btn-app" data-toggle="modal" data-target="#modalAgregarRespuestas" onclick="resetSelect();">
                								<i class="fa fa-check"></i> Respuestas
            							  </a>
							            </div>
							            <div class="box-body">
							                <table class="table table-bordered table-striped dt-responsive tablas">
							                  <thead>
							                    <tr>
							                      <th >NOMBRE</th>
							                      <th >CATEGORÍA</th>
							                      <th >CREACIÓN</th>
							                      <th >ACTUALIZACIÓN</th>
							                      <th style="width:150px">ACCIONES</th>
							                    </tr> 
							                  </thead>
							                  <tbody>
							                <?php
							                      $item = null;
							                      $valor = null;
							                      $items = ControladorPlantillaTrabajo::ctrMostrarPlantillaTrabajo($item, $valor);
							                      foreach ($items as $key => $value)
							                      {
							                          echo ' <tr>
							                                  <td>'.$value["nombrePlantilla"].'</td>
							                                  <td>'.$value["nombreCategoriaPlantilla"].'</td>
							                                  <td>'.$value["fechaCreacion"].'</td>
							                                  <td>'.$value["fechaModificacion"].'/'.$value["Usuario_niu"].'</td>
							                                  <td>
							                                    <div class="btn-group">
							                                      <button class="btn btn-warning btnEditarPlantillaTrabajo" idPlantillaTrabajo="'.$value["idPlantillaTrabajo"].'" data-toggle="modal" data-target="#modalEditarPlantillaTrabajo" title="Editar plantilla"><i class="fa fa-pencil"></i></button>
							                                    </div>
							                                     <button class="btn btn-primary btnCrearSeccionPlantillaTrabajo" idPlantillaTrabajoSeccion="'.$value["idPlantillaTrabajo"].'" data-toggle="modal" data-target="#modalAgregarSeccionPlantillaTrabajo" title="Agregar secciones a esta plantilla"><i class="fa fa-bars" ></i></button>
							                                    <button class="btn btn-success btnCrearItemPlantillaTrabajo" idPlantillaTrabajoI="'.$value["idPlantillaTrabajo"].'" data-toggle="modal" data-target="#modalAgregarItem" title="Agregar Item a esta plantilla"><i class="fa fa-plus" ></i></button>
							                                      <button class="btn btn-info btnVerItemPlantillaTrabajo" idPlantillaTrabajoV="'.$value["idPlantillaTrabajo"].'" data-toggle="modal" data-target="#modalEditarPlantillaTrabajo2" title="Ver items de esta plantilla"><i class="fa fa-eye"></i></button>
							                                  </td>
							                                </tr>';
							                        }
							                ?> 
							                  </tbody>
							                </table>
							            </div>
							    </div>
					    	</div>
					    </div> 
 	</section>
	</div>

<!--=====================================
MODAL AGREGAR PLANTILLA
======================================-->

<div id="modalAgregarPlantillaTrabajo" class="modal fade" role="dialog">
  
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
              
		                <span class="input-group-addon"><i class="fa fa-file"></i></span> 
		                <input type="text" class="form-control input-lg" name="nombrePlantilla" id="nombrePlantilla" placeholder="Ingresar nombre plantilla" required>
            	  </div>
            </div>	
           

            <div class="form-group">
           		 <div class="input-group">
              			<span class="input-group-addon"><i class="fa fa-file"></i></span> 
               			<select class="form-control input-lg" id="CategoriaPlantilla_idCategoriaPlantilla" name="CategoriaPlantilla_idCategoriaPlantilla" required>
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

          <button type="submit" class="btn btn-primary">Guardar plantilla</button>

        </div>

        <?php

          $crearPlantillaTrabajo = new ControladorPlantillaTrabajo();
          $crearPlantillaTrabajo -> ctrCrearPlantillaTrabajo();

        ?>

      </form>

    </div>

  </div>

</div>

<!--=====================================
MODAL AGREGAR SECCION
======================================-->

<div id="modalAgregarSeccionPlantillaTrabajo" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar seccion</h4>

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
		                <input type="text" class="form-control input-lg" name="nombreSeccion" id="nombreSeccion" placeholder="Ingresar nombre seccion" required>
		                <input type="hidden"  name="PlantillaTrabajo_idPlantillaTrabajo" id="PlantillaTrabajo_idPlantillaTrabajo" />
            	  </div>
            </div>	
           </div>
           </div> 
          
          

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar seccion</button>

        </div>

        <?php

          $crearSeccionPlantillaTrabajo = new ControladorSeccionesPlantillaTrabajo();
          $crearSeccionPlantillaTrabajo -> ctrCrearSeccionPlantillaTrabajo();

        ?>

      </form>

    </div>

  </div>

</div>
<!--=====================================
MODAL EDITAR PLANTILLA
======================================-->

<div id="modalEditarPlantillaTrabajo" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar plantilla</h4>

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

                <input type="text" class="form-control input-lg" name="editarPlantillaTrabajo" id="editarPlantillaTrabajo" required>


                 <input type="hidden"  name="idPlantillaTrabajo" id="idPlantillaTrabajo" required>

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

          $editarPlantillaTrabajo = new ControladorPlantillaTrabajo();
          $editarPlantillaTrabajo -> ctrEditarPlantillaTrabajo();

        ?> 

      </form>

    </div>

  </div>

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

          <h4 class="modal-title">Agregar Item</h4>

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
                <input type="hidden" name="idPlantillaTrabajoItem" id="idPlantillaTrabajoItem"  value="" />

              </div>

            </div>
            <div class="form-group">
           		 <div class="input-group">
              			<span class="input-group-addon"><i class="fa fa-file"></i></span> 
               			<select class="form-control input-lg" id="secciones_idsecciones" name="secciones_idsecciones" required>
               				<option value="" >Seccion para agrupar item...</option>
              			 <?php

					        $item  = null;
					        $valor = null;

					        $items = ControladorSeccionesPlantillaTrabajo::ctrMostrarSeccionPlantillaTrabajo($item, $valor);

					       foreach ($items as $key => $value)
					       {
					         
					         echo '<option value="'.$value["idsecciones"].'">'.$value["nombre"].'  </option>';
					                  
					                  
					       }


							?> 

              		    </select>
				
             	 </div>
            </div>
           <div class="form-group">
           	<h4>Presentacion</h4>
           	  <div class="radio">
               
                    <label>
                    <input type="radio" id="FormaOpcion" name="FormaOpcion[]" value="1"> Listado
                   </label>
              </div>
               <div class="radio">    
                    <label>
                    <input type="radio" id="FormaOpcion" name="FormaOpcion[]" value="2"> Botones
                   </label>
			 		
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

          $crearItemPlantillaTrabajo = new ControladorItemPlantillaTrabajo();
          $crearItemPlantillaTrabajo -> ctrCrearItemPlantillaTrabajo();

        ?>

      </form>

    </div>

  </div>

</div>

<!--=====================================
MODAL AGREGAR RESPUESTAS
======================================-->

<div id="modalAgregarRespuestas" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">
      <input type="hidden" name="etiquetasItem" id="etiquetasItem"  value="" />
      <input type="hidden" name="valoresItem" id="valoresItem"  value="" />
      <input type="hidden" name="etivaloresItem" id="etivaloresItem"  value="" />
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar Respuestas</h4> 

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


             <div class="form-group">
	              <h4>Respuestas</h4> 
	              
	                <div class="col-md-5">
	                    <input type="text" class="form-control" id="etiqueta" name="etiqueta" placeholder="Etiqueta">
	                </div>
	                <div class="col-md-5">
	                    <input type="text" class="form-control" id="valor" name="valor" placeholder="Valor">
	                </div>
	              <div class="col-md-2">
		              <button class="btn btn-success btn-add" type="button" onclick="AddOptionE()">
		                 <span class="glyphicon glyphicon-plus"></span>
		              </button>
	              </div>
	             
					        
            
             </div> 
              <h4>Listado</h4>
            <div class="form-group" id="etiqueta_valor">
           

	     	 	
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

          $crearRespuestaPlantillaTrabajo = new ControladorPlantillaTrabajo();
          $crearRespuestaPlantillaTrabajo -> ctrCrearRespuestaItemPlantillaTrabajo();

        ?>

      </form>

    </div>

  </div>

</div>
<form id="target_view" name="target_view" role="form" method="post" enctype="multipart/form-data" action="mostrar-item">
  <input type="hidden" name="plantillaitem_id" id="plantillaitem_id" value="">
  
</form>
