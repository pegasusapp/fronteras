<?php
                        if(!isset($_POST["solicitud_id"]))
                                {
                                    echo '<script>
                                          window.location = "solicitudes";
                                          </script>'; 
                                }
                          else
                                {
                                    $item = "idsolicitudes";
                                    $valor = $_POST["solicitud_id"];
                                    $items = ControladorSolicitud::ctrMostrarSolicitudProyeccion($item, $valor);
                                    $solicitud_sesion=$items["nro_solicitud"];
                                }
                ?> 
<form id="myForm" enctype="multipart/form-data"  role="form" data-toggle="validator" method="post" accept-charset="utf-8" action="mostrarSolicitud">
<input type="hidden" name="idsolicitudes" id="idsolicitudes" value="<?php echo $_POST["solicitud_id"]; ?>" />
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Solicitud # <?php echo $solicitud_sesion;  ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Datos solicitud</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title"><button class="btn btn-primary btnAtrasSolicitud" onclick="location.href='solicitudes'" data-toggle="modal" data-target="#modalAgregarPlantillaTrabajo">Atras</button>
</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>-->
            </div>
          </div>
        <!-- /.box-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputNiu">NIU</label>
                    <input type="text" class="form-control" id="Usuario_niu"  value="<?php echo $items["Usuario_niu"]?>" disabled>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label for="exampleInputFs">Fecha solicitud</label>
                    <input type="text" class="form-control" id="fecha_solicitud" value="<?php echo $items["fecha_solicitud"]?>" disabled>
                </div>
             </div>  
            <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputEmail">e-mail</label>
                    <input type="text" class="form-control" id="email" value="<?php echo $items["email"]?>" disabled>
                </div>
                <div class="form-group">
                  <label for="exampleInputtlf">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" value="<?php echo $items["telefono"]?>" disabled>
                </div>
              </div>
            <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputNs">Transformador</label>
                    <input type="text" class="form-control" id="trafo_solicitud" value="<?php echo $items["transformador_codigo_transformador"]?>" disabled>
                </div>
                <div class="form-group">
                  <label for="exampleInputtlf">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" value="<?php echo $items["telefono"]?>" disabled>
                </div>
            </div>
            <div class="col-md-4">
            	  <div class="form-group">
                    <label for="exampleInputNs">Número solicitud</label>
                   <input type="text" class="form-control" id="nro_solicitud" value="<?php echo $items["nro_solicitud"]?>" disabled>
                </div>
               
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label for="exampleInputNs">Capacidad trafo</label>
                    <input type="text" class="form-control" id="capacidad_trafo_solicitud" value="<?php echo $items["capacidad_nominal"]?>" disabled>
                </div>
             
               
            </div>
            <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleInputNs">Capacidad trafo</label>
                    <input type="text" class="form-control" id="capacidad_trafo_solicitud" value="<?php echo $items["capacidad_nominal"]?>" disabled>
                </div>
               
            </div>	


              <!-- /.form-group -->
            </div>
           
            <!-- /.col -->

            <div class="row">
                <div class="col-md-12">
                            <h5 class="card-header info-color py-2" style="text-align:center; margin-bottom:15px; margin-top:15px">
                                <strong>TIPO DE GENERACIÓN A INSTALAR</strong>
                            </h5>
                </div>
           </div>
           <div class="row">
            <div class="col-md-6">
              <!-- /.form-group -->
              <div class="form-group">
                <label for="exampleInputtgi">Tipo generación instalar</label>
                  <input type="text" class="form-control" id="tipo_generacion_instalar" value="<?php echo $items["tipo_generacion_instalar"]?>" disabled>
              </div>
              <!-- /.form-group -->
               <div class="form-group">
                <label for="exampleInputtgi">¿Entrega excedentes a la red?</label>
                  <input type="text" class="form-control" id="entrega_excedentes_red" value="<?php echo $items["entrega_excedentes_red"]?>" disabled>
              </div>
             
            </div>
            <!-- /.col -->
            <div class="col-md-6">
            	 <!-- /.form-group -->
		            <div class="form-group">
		                <label for="exampleInputtgi">Fecha conexión del proyecto</label>
		                  <input type="text" class="form-control" id="fecha_generacion_autogeneracion" value="<?php echo $items["fecha_generacion_autogeneracion"]?>" disabled>
		            </div>
		            <div class="form-group">
		                <label for="exampleInputtgi">Fecha entrada en operación comercial</label>
		                  <input type="text" class="form-control" id="fecha_generacion_distribucion" value="<?php echo $items["fecha_generacion_distribucion"]?>" disabled>
		            </div>
            </div> 
           </div> 
           <div class="row">
                <div class="col-md-12">
                            <h5 class="card-header info-color py-2" style="text-align:center; margin-bottom:15px; margin-top:15px">
                                <strong>DATOS DEL PUNTO DE CONEXIÓN</strong>
                            </h5>
                </div>
           </div>
           <div class="row">
           	<div class="col-md-12">

              <div class="form-group">
                <label for="exampleInputpi">Potencia instalada en KVA</label>
                  <input type="text" class="form-control" id="potencia_instalada_kva" value="<?php echo $items["potencia_instalada_kva"]?>" disabled>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label for="exampleInputtgi">Potencia a entregar a la red (kW)</label>
                  <input type="text" class="form-control" id="potencia_entregar_red" value="<?php echo $items["potencia_entregar_red"]?>" disabled>
              </div>
              <!-- /.form-group -->
               <div class="form-group">
                <label for="exampleInputtgi">Nivel de tensión(V)</label>
                  <input type="text" class="form-control" id="nivel_tension" value="<?php echo $items["nivel_tension"]?>" disabled>
              </div>

            </div>
          </div>

          <!-- /.row -->
           <div class="row">
                <div class="col-md-12">
                            <h5 class="card-header info-color py-2" style="text-align:center; margin-bottom:15px; margin-top:15px">
                                <strong>TIPO DE TECNOLOGÍA UTILIZADA</strong>
                            </h5>
                </div>
           </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="exampleInputTtu">Tipo de tecnología a usar</label>
                  <input type="text" class="form-control" id="tipo_tecnologia_utilizada" value="<?php echo $items["tipo_tecnologia_utilizada"]?>" disabled>
              </div>
           </div>
          </div>
          <div class="row">
	           <div class="col-md-6">    
	              <!-- /.form-group -->
	              <div class="form-group">
	                <label for="exampleInputPp">Potencia por panel(W)</label>
	                  <input type="text" class="form-control" id="potencia_panel" value="<?php echo $items["potencia_panel"]?>" disabled>
	              </div>
	              <div class="form-group">
	                <label for="exampleInputFi">Fecha de instalación</label>
	                  <input type="text" class="form-control" id="fecha_instalacion_solar_fv" value="<?php echo $items["fecha_instalacion_solar_fv"]?>" disabled>
	              </div>
	              <div class="form-group">
	                <label for="exampleInputEmail">Número de paneles</label>
	                  <input type="text" class="form-control" id="nro_paneles" value="<?php echo $items["nro_paneles"]?>" disabled>
	              </div>
	              <div class="form-group">
	                <label for="exampleInputPrfi">Posee relé de flujo inverso</label>
	                  <input type="text" class="form-control" id="rele_flujo_inverso" value="<?php echo $items["rele_flujo_inverso"]?>" disabled>
	              </div>
	              <!-- /.form-group -->
	            </div>
            <!-- /.col -->
	            <div class="col-md-6">
	             <!-- /.form-group -->
	              <div class="form-group">
	                <label for="exampleInputtgi">Capacidad en DC (kW DC)</label>
	                  <input type="text" class="form-control" id="capacidad_dc" value="<?php echo $items["capacidad_dc"]?>" disabled>
	              </div>
	              <!-- /.form-group -->
	               <div class="form-group">
	                <label for="exampleInputtgi">Potencia total en AC (kW AC)</label>
	                  <input type="text" class="form-control" id="potencia_total" value="<?php echo $items["potencia_total"]?>" disabled>
	              </div>
	              <!-- /.col -->
	              <div class="form-group">
	                <label for="exampleInputvsi">Voltaje salida del inversor (V)</label>
	                  <input type="text" class="form-control" id="voltaje_salida" value="<?php echo $items["voltaje_salida"]?>" disabled>
	              </div>
	              <div class="form-group">
	                <label for="exampleInputpi">Número de fases</label>
	                  <input type="text" class="form-control" id="numero_fases" value="<?php echo $items["potencia_entregar_red"]?>" disabled>
	              </div>
				</div>
		    </div>
		    <div class="row">
	              <div class="col-md-6">
	                   <div class="form-group">
	                    <label for="exampleInputtgi">Indicaciones de los elementos de protección,control y maniobra</label>
	                    <TEXTAREA  class="form-control" id="descripcion_elementos_proteccion" value="<?php echo $items["descripcion_elementos_proteccion"]?>" disabled></TEXTAREA> 
	                  </div>
	              </div>    
	              <!-- /.form-group -->
	              <div class="col-md-6">
	               <div class="form-group">
	                <label for="exampleInputtgi">Especificaciones  de las caracteristicas del inversor</label>
	                   <TEXTAREA  class="form-control" id="descripcion_caracteristicas_inversor" value="<?php echo $items["descripcion_caracteristicas_inversor"]?>" disabled></TEXTAREA> 
	              </div>
	            </div>
            </div>	
		    <div class="row">
		      <div class="col-md-6">	
	              <!-- /.form-group -->
	              <div class="form-group">
	                <label for="exampleInputvsi">Cumple estándar IEEE 1547-2003</label>
	                  <input type="text" class="form-control" id="estandar_ieee" value="<?php echo $items["estandar_ieee"]?>" disabled>
	              </div>
	          </div> 
	          <div class="col-md-6">	   
	              <div class="form-group">
	                <label for="exampleInputpi">Cumple estándar UL 1741-2010</label>
	                  <input type="text" class="form-control" id="estandar_ul" value="<?php echo $items["estandar_ul"]?>" disabled>
	              </div>
              </div>
          </div>
 <!----------------------------------------------------------------------------------------------------------------------------------------------- -->         
        <!-- /.row -->
           <div class="row">
                <div class="col-md-12">
                            <h5 class="card-header info-color py-2" style="text-align:center; margin-bottom:15px; margin-top:15px">
                                <strong>GENERADOR</strong>
                            </h5>
                </div>
           </div>
           <div class="row">
             <div class="col-md-12">
              <div class="form-group">
                <label for="exampleInputvsi">Fabricante del generador</label>
                  <input type="text" class="form-control" id="fabricante_generador" value="<?php echo $items["fabricante_generador"]?>" disabled>
              </div>
             </div>
           </div>   
          <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                <label for="exampleInputvsi">Modelo del generador</label>
                  <input type="text" class="form-control" id="modelo_generador" value="<?php echo $items["modelo_generador"]?>" disabled>
              </div>
               <div class="form-group">
                <label for="exampleInputvsi">Voltaje del generador(V)</label>
                  <input type="text" class="form-control" id="voltaje_generador" value="<?php echo $items["voltaje_generador"]?>" disabled>
              </div>
               <div class="form-group">
                <label for="exampleInputvsi">Potencia nominal (kVA)</label>
                  <input type="text" class="form-control" id="potencia_nominal" value="<?php echo $items["potencia_nominal"]?>" disabled>
              </div>
             </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputvsi">Factor de potencia</label>
                    <input type="text" class="form-control" id="factor_potencia" value="<?php echo $items["factor_potencia"]?>" disabled>
                </div>
                <div class="form-group">
                  <label for="exampleInputvsi">Número de fases</label>
                    <input type="text" class="form-control" id="numero_fases_generador" value="<?php echo $items["numero_fases_generador"]?>" disabled>
                </div>
                <div class="form-group">
                  <label for="exampleInputvsi">Reactancia subtransitoria xd"(p.u)</label>
                    <input type="text" class="form-control" id="reactancia_subtransitoria" value="<?php echo $items["reactancia_subtransitoria"]?>" disabled>
                </div>
              </div>
           </div>
   
          <!-- /.row -->
          <div class="row">
                <div class="col-md-12">
                            <h5 class="card-header info-color py-2" style="text-align:center; margin-bottom:15px; margin-top:15px">
                                <strong>TRANSFORMADOR(Si aplica)</strong>
                            </h5>
                </div>
           </div>

          <div class="row"> 
              <div class="col-md-6">
                 <div class="form-group">
                  <label for="exampleInputvsi">Potencia nominal (kVA)</label>
                    <input type="text" class="form-control" id="potencia_nominal_trafo" value="<?php echo $items["potencia_nominal_trafo"]?>" disabled>
                </div>
                <div class="form-group">
                  <label for="exampleInputvsi">Impedancia de C.C (%)</label>
                    <input type="text" class="form-control" id="impedancia_cc" value="<?php echo $items["impedancia_cc"]?>" disabled>
                </div>
              </div>

             <div class="col-md-6">
                 
                <div class="form-group">
                  <label for="exampleInputvsi">Grupo de conexión</label>
                    <input type="text" class="form-control" id="grupo_conexion" value="<?php echo $items["grupo_conexion"]?>" disabled>
                </div>

                  <div class="form-group">
                  <label for="exampleInputvsi">Cumple estándar IEEE 1547-2003</label>
                    <input type="text" class="form-control" id="estandar_ieee_ni" value="<?php echo $items["estandar_ieee_ni"]?>" disabled>
                </div>

              </div>
          </div>    
         
          <div class="row">
             <div class="col-md-12">
               <div class="form-group">
              <label for="exampleInputvsi">Indicar los elementos de protección,control y maniobra:</label>
               <TEXTAREA  class="form-control" id="descripcion_elementos_proteccion_trafo" value="<?php echo $items["descripcion_elementos_proteccion_trafo"]?>" disabled ></TEXTAREA> 
             </div>
             </div>
          </div>
          <!-- /.row -->
          <div class="row">
                <div class="col-md-12">
                            <h5 class="card-header info-color py-2" style="text-align:center; margin-bottom:15px; margin-top:15px">
                                <strong>INFORMACIÓN DEL SISTEMA DE MEDICIÓN</strong>
                            </h5>
                </div>
           </div>
          <div class="row">
             <div class="col-md-6">
               <div class="form-group">
                  <label for="exampleInputvsi">¿El medidor es bidireccional?</label>
                    <input type="text" class="form-control" id="medidor_bidireccional" value="<?php echo $items["medidor_bidireccional"]?>" disabled>
               </div>
             </div>
              <div class="col-md-6">
               <div class="form-group">
                  <label for="exampleInputvsi">¿El medidor tiene perfil horario?</label>
                    <input type="text" class="form-control" id="medidor_perfil_horario" value="<?php echo $items["medidor_perfil_horario"]?>" disabled>
               </div>
             </div>

          </div>
          <div class="row">
                <div class="col-md-12">
                            <h5 class="card-header info-color py-2" style="text-align:center; margin-bottom:15px; margin-top:15px">
                                <strong>PROYECCIÓN DE ENERGÍA GENERADA Y CONSUMIDA (kWh-mes) - Información opcional</strong>
                            </h5>
                </div>
           </div>
           <div class="row">     
                <div class="col-md-12">
                  Proyección de la energía generada por el sistema a entregar a la red del OR por mes (kWh-mes)
                  <div class="table-responsive">
                <table class="table table-bordered table-striped table-highlight">
                  <thead>
                    <th>Mes 1</th>
                    <th>Mes 2</th>
                    <th>Mes 3</th>
                    <th>Mes 4</th>
                    <th>Mes 5</th>
                    <th>Mes 6</th>
                    <th>Mes 7</th>
                    <th>Mes 8</th>
                    <th>Mes 9</th>
                    <th>Mes 10</th>
                    <th>Mes 11</th>
                    <th>Mes 12</th>
                  </thead>
                  <tbody>
                    <tr>
                      <td><input type="text" name="proy_ener_gen_or_m1" id="proy_ener_gen_or_m1" class="form-control" value="<?php echo $items["proy_ener_gen_or_m1"]; ?>" disabled /></td>
                      <td><input type="text" name="proy_ener_gen_or_m2" id="proy_ener_gen_or_m2" class="form-control" value="<?php echo $items["proy_ener_gen_or_m2"]; ?>" disabled /></td>
                      <td><input type="text" name="proy_ener_gen_or_m3" id="proy_ener_gen_or_m3" class="form-control" value="<?php echo $items["proy_ener_gen_or_m3"]; ?>" disabled /></td>
                      <td><input type="text" name="proy_ener_gen_or_m4" id="proy_ener_gen_or_m4" class="form-control" value="<?php echo $items["proy_ener_gen_or_m4"]; ?>" disabled /></td>
                      <td><input type="text" name="proy_ener_gen_or_m5" id="proy_ener_gen_or_m5" class="form-control" value="<?php echo $items["proy_ener_gen_or_m5"]; ?>" disabled /></td>
                      <td><input type="text" name="proy_ener_gen_or_m6" id="proy_ener_gen_or_m6" class="form-control" value="<?php echo $items["proy_ener_gen_or_m6"]; ?>" disabled /></td>
                      <td><input type="text" name="proy_ener_gen_or_m7" id="proy_ener_gen_or_m7" class="form-control" value="<?php echo $items["proy_ener_gen_or_m7"]; ?>" disabled /></td>
                      <td><input type="text" name="proy_ener_gen_or_m8" id="proy_ener_gen_or_m8" class="form-control" value="<?php echo $items["proy_ener_gen_or_m8"]; ?>" disabled /></td>
                      <td><input type="text" name="proy_ener_gen_or_m9" id="proy_ener_gen_or_m9" class="form-control" value="<?php echo $items["proy_ener_gen_or_m9"]; ?>" disabled /></td>
                      <td><input type="text" name="proy_ener_gen_or_m10" id="proy_ener_gen_or_m10" class="form-control" value="<?php echo $items["proy_ener_gen_or_m10"]; ?>" disabled /></td>
                      <td><input type="text" name="proy_ener_gen_or_m11" id="proy_ener_gen_or_m11" class="form-control" value="<?php echo $items["proy_ener_gen_or_m11"]; ?>" disabled /></td>
                      <td><input type="text" name="proy_ener_gen_or_m12" id="proy_ener_gen_or_m12" class="form-control" value="<?php echo $items["proy_ener_gen_or_m12"]; ?>" disabled /></td>
                    </tr>
                  </tbody>
                </table>
          </div>
                </div>
           </div>
           <div class="row">     
                <div class="col-md-12">
                  Proyección de la energía generada por el sistema para consumo interno por mes (kWh-mes)
                  <div class="table-responsive">
			                <table class="table table-bordered table-striped table-highlight">
			                  <thead>
			                    <th>Mes 1</th>
			                    <th>Mes 2</th>
			                    <th>Mes 3</th>
			                    <th>Mes 4</th>
			                    <th>Mes 5</th>
			                    <th>Mes 6</th>
			                    <th>Mes 7</th>
			                    <th>Mes 8</th>
			                    <th>Mes 9</th>
			                    <th>Mes 10</th>
			                    <th>Mes 11</th>
			                    <th>Mes 12</th>
			                  </thead>
			                  <tbody>
			                    <tr>
			                      <td><input type="text" name="proy_ener_gen_ci_m1" id="proy_ener_gen_ci_m1" class="form-control" value="<?php echo $items["proy_ener_gen_ci_m1"]; ?>" disabled /></td>
			                      <td><input type="text" name="proy_ener_gen_ci_m2" id="proy_ener_gen_ci_m2" class="form-control" value="<?php echo $items["proy_ener_gen_ci_m2"]; ?>" disabled /></td>
			                      <td><input type="text" name="proy_ener_gen_ci_m3" id="proy_ener_gen_ci_m3" class="form-control" value="<?php echo $items["proy_ener_gen_ci_m3"]; ?>" disabled /></td>
			                      <td><input type="text" name="proy_ener_gen_ci_m4" id="proy_ener_gen_ci_m4" class="form-control" value="<?php echo $items["proy_ener_gen_ci_m4"]; ?>" disabled /></td>
			                      <td><input type="text" name="proy_ener_gen_ci_m5" id="proy_ener_gen_ci_m5" class="form-control" value="<?php echo $items["proy_ener_gen_ci_m5"]; ?>" disabled /></td>
			                      <td><input type="text" name="proy_ener_gen_ci_m6" id="proy_ener_gen_ci_m6" class="form-control" value="<?php echo $items["proy_ener_gen_ci_m6"]; ?>" disabled/></td>
			                      <td><input type="text" name="proy_ener_gen_ci_m7" id="proy_ener_gen_ci_m7" class="form-control" value="<?php echo $items["proy_ener_gen_ci_m7"]; ?>" disabled /></td>
			                      <td><input type="text" name="proy_ener_gen_ci_m8" id="proy_ener_gen_ci_m8" class="form-control" value="<?php echo $items["proy_ener_gen_ci_m8"]; ?>" disabled /></td>
			                      <td><input type="text" name="proy_ener_gen_ci_m9" id="proy_ener_gen_ci_m9" class="form-control" value="<?php echo $items["proy_ener_gen_ci_m9"]; ?>" disabled /></td>
			                      <td><input type="text" name="proy_ener_gen_ci_m10" id="proy_ener_gen_ci_m10" class="form-control" value="<?php echo $items["proy_ener_gen_ci_m10"]; ?>" disabled /></td>
			                      <td><input type="text" name="proy_ener_gen_ci_m11" id="proy_ener_gen_ci_m11" class="form-control" value="<?php echo $items["proy_ener_gen_ci_m11"]; ?>" disabled /></td>
			                      <td><input type="text" name="proy_ener_gen_ci_m12" id="proy_ener_gen_ci_m12" class="form-control" value="<?php echo $items["proy_ener_gen_ci_m12"]; ?>" disabled /></td>
			                    </tr>
			                  </tbody>
			                </table>
        		  </div>
                </div>
           </div>
           <div class="row">
           	    <div class="col-md-12">
	                <div class="form-group">
    	              <label for="exampleInputvsi">Documento del proyecto</label>
                    <a href="http://www.ruitoqueesp.com/web/res030/solicitudes/<?php echo $items["Usuario_niu"]; ?>/<?php echo $items["nombre_archivo"]; ?>" target=_blank><i class="fa fa-fw fa-file-text-o">Archivo </i></a>
               	   </div>
                </div>
           </div>
           <div class="row">     
                <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInputvsi">Observaciones del proyecto</label>
                    <TEXTAREA  class="form-control" id="descripcion_gral_proyecto"  disabled><?php echo $items["descripcion_gral_proyecto"]?></TEXTAREA> 
                    </div>
                </div>
          </div>
          <div class="row">
          	<div class="col-md-12">
 				<div class="form-group">
 					 <label for="exampleInputvsi">Estado de la solicitud</label>
          			 <Select class="form-control" id="estado_solicitud_idestado_solicitud" name="estado_solicitud_idestado_solicitud">
                   <?php

                        $item = null;
                        $valor = null;

                        $items_estado = ControladorEstadoSolicitud::ctrMostrarEstadoSolicitud($item, $valor);
                        $vlr_seleccionado="";
                       foreach ($items_estado as $key => $value)
                           {
                                 
                           		 if ($items["estado_solicitud_idestado_solicitud"]==$value["idestado_solicitud"]){$vlr_seleccionado="Selected";}else{$vlr_seleccionado="";}
                                  echo '<option  value="'.$value["idestado_solicitud"].'" '.$vlr_seleccionado.'>'.$value["nombre"].'</option>';
                           }
                       ?>
                      </Select>
              </div>
            </div>
       
          
          </div>
            <div class="row">     
                <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInputvsi">Observaciones de la empresa</label>
                    <TEXTAREA  class="form-control" id="observaciones_empresa" name="observaciones_empresa" ><?php echo $items["observaciones_empresa"]?></TEXTAREA> 
                    </div>
                </div>
          </div>
          <div class="row">
          	<div class="col-md-12">
          		
				<div class="form-group">
					 <label for="exampleInputvsi"></label>
				         <a href="solicitudes"><button data-trans class="btn btn-block btn-primary" type="submit">Guardar cambios</button></a>		
				</div>	
          
          	</div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="card-footer">
          <button class="btn btn-primary btnAtrasSolicitud" onclick="location.href='solicitudes'" data-toggle="modal" data-target="#modalAgregarPlantillaTrabajo">Atras</button>
        </div>
      </div>
  </section>
       <?php

          $EditarSolicitud = new ControladorSolicitud();
          $EditarSolicitud -> ctrEditarSolicitud();
          
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
</div>
</form>