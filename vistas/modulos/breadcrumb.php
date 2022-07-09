<?php
$tabla="subproceso";
   $item="plantillaSubproceso";
   $valor=$_GET["ruta"];
   $plantillasActivas = ModeloSubproceso::mdlMostrarSubproceso($tabla,$item,$valor);
   $nameModule = (empty($plantillasActivas["nombreSubproceso"])) ? "Inicio" : $plantillasActivas["nombreSubproceso"]; 
   $template = (empty($plantillasActivas["nombreSubproceso"])) ? "404.php" : $plantillasActivas["nombreSubproceso"]."php"; 

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
          </div>
        </div>
      </div>
    </div>