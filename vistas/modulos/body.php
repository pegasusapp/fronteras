<?php 
   $plantillasActivas = array("inicio" =>"inicio.php",
                              "crearUsuario" => "crearUsuario.php",
                              "editMenu" => "editMenu.php",
                              "listadoFronteras" => "listadoFronteras.php",
                              "datosPersonales" => "datosPersonales.php",
                              "datosGenerados" => "datosGenerados.php",
                              "listadoClientes" => "listadoClientes",
                              "uploadFile" => "uploadFile.php",
                              "uploadConsumo" => "uploadConsumo.php",
                              "descargaFactura" => "descargaFactura.php",
                              "desviacion" => "desviacion.php",
                              "salir" => "salir.php"
                                );
  if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok"):?>
    <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
         <?php 
          include "cabezote.php";
          include "menu.php"; 
           if(isset($_GET["ruta"])){
               if(isset($plantillasActivas[$_GET["ruta"]])){
                      include $_GET["ruta"].".php";
                    }
                else{
                      include "404.php";
                    }
          }else{
            include "inicio.php";
          }
         include "footer.php"; ?>
      </div>
  <?php else:?>
    <body class="login-page"> 
  <?=include "login.php";?>
  <?php endif;?>