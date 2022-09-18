<?php
   $tabla="subproceso";
   $item="plantillaSubproceso";
   $valor=$_GET["ruta"];
   $template="salir.php";
   if($valor != "salir")
   {
    if($valor =="editMenu")
    {
      $nameModule = "Permisos de usuario";
      $template = "editMenu.php";
    }
    elseif($valor =="datosGenerados"){
      $nameModule = "Datos generados";
      $template = "datosGenerados.php";
    }
    else{
      $plantillasActivas = ModeloSubproceso::mdlMostrarSubproceso($tabla,$item,$valor);
      $nameModule = (empty($plantillasActivas["plantillaSubproceso"])) ? "Inicio" : $plantillasActivas["nombreSubproceso"]; 
      $template = (empty($plantillasActivas["plantillaSubproceso"])) ? "inicio.php" : $plantillasActivas["plantillaSubproceso"].".php"; 
    
    }
  }
    

  ?>
<div class="content-header"> 
      <section class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?=$nameModule?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Home</a></li>
              <li class="breadcrumb-item active"><?=$nameModule?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>