<?php 

  if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok"):?>
    <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
         <?php 
          include "cabezote.php";
          include "menu.php"; 
          include "breadcrumb.php"; 
           if(isset($_GET["ruta"])){
                include $template;
              }
            else{
                include "inicio.php";
          }
         include "footer.php"; ?>
      </div>
  <?php else:?>
    <body class="login-page"> 
  <?=include "login.php";?>
  <?php endif;?>