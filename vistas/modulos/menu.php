 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="inicio" class="brand-link">
      <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">-->
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
      <span class="brand-text font-weight-light"><?php echo Constantes::NOMBRE_EMPRESA; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <?php

        if($_SESSION['nuevaFoto'] == "" )
           {
            echo '<img src="vistas/img/usuarios/default/anonymous.png" class="img-circle elevation-2" alt="Imagen de perfil de '.$_SESSION["identificador"].'"/>';
           }
         else 
           {
            echo '<img src="'.$_SESSION['nuevaFoto'].'" class="img-circle elevation-2" alt="User Image"/>';
           }
                    

         ?>
         
        </div>
        <div class="info">
          <a href="#" class="d-block">
			  <?php
			  	echo $_SESSION["nombreCompleto"]
					 ?>
		</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
			   with font-awesome or any other icon font library -->
		       <?php

						
              $valor = $_SESSION["identificador"];
              

              $items = ControladorMenu::ctrMostrarMenu($valor);
              $menudesplegado = array();
            foreach ($items as $key => $value)
            {
                
                           echo '<li class="nav-item has-treeview menu-close" id="servicio_'.$value["idServicio"].'">
                            <a href="#" class="nav-link active">
                              <i class="nav-icon fas '.$value["icono"].'"></i>
                              <p>
                                '.$value["nombreServicio"].'
                                <i class="right fas fa-angle-left"></i>
                              </p>
                            </a>
                            <ul class="nav nav-treeview">';
                            $operacionProcesoM=explode(",", $value["proceso_nombre"]);
                            $operacionidProcesoM=explode(",", $value["procesos_id"]);
                          
                            for ($j=0;$j<count($operacionProcesoM); $j++)
                              {
                              
                                $operacionProcesoNeI = explode("*",$operacionProcesoM[$j]);
                                
                                echo '<li class="nav-item has-treeview" id="proceso_'.$operacionidProcesoM[$j].'">
                                       <a href="./index.html" class="nav-link">
                                         <i class="nav-icon fas '.$operacionProcesoNeI[1].'"></i>
                                         <p>'.$operacionProcesoNeI[0].'<i class="fas fa-angle-left right"></i></p>
                                        </a>
                                          <ul class="nav nav-treeview">';
                                            $operacionSubproceso=explode(",", $value["nombreSubproceso"]);
                                            $operacionPlantilla=explode(",", $value["nombrePlantillas"]);
                                            $operacionIdSubproceso=explode(",", $value["subprocesos_id"]);

                                          for ($i=0; $i<count($operacionSubproceso); $i++)
                                              {
                                          
                                                $idsubproceso_brokenM = explode("-",$operacionIdSubproceso[$i]);
                                              
                                                 if($operacionidProcesoM[$j]==$idsubproceso_brokenM[0])
                                                  {
                                                    echo '<li class="nav-item">
                                                            <a href="'.$operacionPlantilla[$i].'" class="nav-link">
                                                             <i class="far fa-circle nav-icon" id="subproceso_'.$idsubproceso_brokenM[1].'"></i>
                                                             <p>'.$operacionSubproceso[$i].'</p>
                                                             </a>
                                                           </li>';
                                                  }
                                              }
                                  echo'</ul>
                                    </li>';
                              }
                             echo '</ul>
                                  </li>
                                  ';
              
               
              
            
              }
              
			     ?> 	   

 
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>