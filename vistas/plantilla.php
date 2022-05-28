<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>SoftFocus(™)</title>
  <meta content="text/html; charset=utf-8" http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" >
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" >
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- sweet alert -->
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="plugins/tree/js/hummingbird-treeview.js"></script> 
<!-- sweet alert -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- tree -->
<link  rel="stylesheet"  href="plugins/tree/css/hummingbird-treeview.css" rel="stylesheet">
</head>
<!--=====================================
CUERPO DOCUMENTO
======================================-->
  <?php


  if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok"){
    echo '<body class="hold-transition sidebar-mini layout-fixed"><div class="wrapper">';
    /*=============================================
    CABEZOTE
    =============================================*/

    include "modulos/cabezote.php";

    /*=============================================
    MENU
    =============================================*/

    include "modulos/menu.php";

    /*=============================================
    CONTENIDO
    =============================================*/

    if(isset($_GET["ruta"])){
      if($_GET["ruta"] == "inicio" ||
         $_GET["ruta"] == "categorias" ||
         $_GET["ruta"] == "productos" ||
         $_GET["ruta"] == "clientes" ||
         $_GET["ruta"] == "crear-categoria" ||
         $_GET["ruta"] == "crear-categoriaItem" ||
         $_GET["ruta"] == "crear-perfil" ||
         $_GET["ruta"] == "crearUsuario" ||
         $_GET["ruta"] == "editMenu" ||
         $_GET["ruta"] == "crear-opciones" ||
         $_GET["ruta"] == "crear-documento" ||
         $_GET["ruta"] == "gestion-empresa" ||
         $_GET["ruta"] == "mostrar-item" || 
         $_GET["ruta"] == "mostrar-item-documento" ||
         $_GET["ruta"] == "graficas" ||
         $_GET["ruta"] == "solicitudes" ||
         $_GET["ruta"] == "alterno" ||
         $_GET["ruta"] == "listadoFronteras" ||
         $_GET["ruta"] == "info" ||
         $_GET["ruta"] == "info2" ||
         $_GET["ruta"] == "info3" ||
         $_GET["ruta"] == "datosPersonales" ||
         $_GET["ruta"] == "datosGenerados" ||
         $_GET["ruta"] == "listadoClientes" ||
         $_GET["ruta"] == "uploadFile" ||
         $_GET["ruta"] == "dfiles" ||
         $_GET["ruta"] == "salir"){

        include "modulos/".$_GET["ruta"].".php";

      }else{

        include "modulos/404.php";

      }

    }else{

      include "modulos/inicio.php";

    }

    /*=============================================
    FOOTER
    =============================================*/

    include "modulos/footer.php";

    echo '</div>';

  }else{
    echo '<body class="login-page">'; 
    include "modulos/login.php";

  }

  ?>
 

<script src="vistas/js/usuarios.js"></script>
<script src="vistas/js/fronteras.js"></script>
<script src="vistas/js/solicitudes.js"></script>
<script src="vistas/js/clientes.js"></script>
<script src="vistas/js/area.js"></script>
<script src="vistas/js/fuentes.js"></script>
<script src="vistas/js/totales.js"></script> 
<script src="vistas/js/perfiles.js"></script>
<script src="vistas/js/equipos.js"></script>
<script src="vistas/js/produccion.js"></script>          
<script src="vistas/js/alterno.js"></script> 
<script src="vistas/js/permisos.js"></script> 
<script src="vistas/js/gproyecto.js"></script> 

<script>

$("#treeview").hummingbird();
// Collapsed Symbol
$.fn.hummingbird.defaults.collapsedSymbol= "fa-plus";

// Expand Symbol
$.fn.hummingbird.defaults.expandedSymbol= "fa-minus";

// Set this to "disabled" to disable all checkboxes from nodes that are parents
$.fn.hummingbird.defaults.checkboxesGroups= "enabled"; 

// Enable the functionality to account for disabled nodes
$.fn.hummingbird.defaults.checkDisabled= true;

// Collapse all nodes on init
$.fn.hummingbird.defaults.collapseAll= true; 

// Enable checkboxes
$.fn.hummingbird.defaults.checkboxes= "enabled"; 


// check all nodes
$("#treeview").hummingbird("checkAll");

// uncheck all nodes
$("#treeview").hummingbird("uncheckAll");

// collapse all nodes
$("#treeview").hummingbird("collapseAll");

// expand all nodes
$("#treeview").hummingbird("expandAll");

$("#treeview").on("nodeChecked", function(){
  // when checked
});

$("#treeview").on("nodeUnchecked", function(){
  // when unchecked
});

$("#treeview").on("CheckUncheckDone", function(){
  // when checked or unchecked
});

</script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>


<!-- DataTables -->
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<script src="vistas/js/plantilla.js"></script>
<?php
 $paginaNiveles =  $_SERVER["REQUEST_URI"];
 $paginaSesion = explode("/", $paginaNiveles);
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
</body>
</html>
