<?php
$tabla="subproceso";
   $item="plantillaSubproceso";
   $valor=$_GET["ruta"];
   if($valor != "salir")
   {
    $plantillasActivas = ModeloSubproceso::mdlMostrarSubproceso($tabla,$item,$valor);
    $nameModule = (empty($plantillasActivas["plantillaSubproceso"])) ? "Inicio" : $plantillasActivas["nombreSubproceso"]; 
    $template = (empty($plantillasActivas["plantillaSubproceso"])) ? "inicio.php" : $plantillasActivas["plantillaSubproceso"].".php"; 
    }
    else{
        $template="salir.php";
    }

  ?>
<div class="content-header"> 
      <div class="container-fluid">
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
    </div>