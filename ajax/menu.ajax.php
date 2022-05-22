<?php
require_once "../controladores/menu.controlador.php";
require_once "../modelos/menu.modelo.php";

class AjaxMenu
{

	/*=============================================
	EDITAR MENU
	=============================================*/	

	public $identificador;

	public function ajaxMenuUsuario(){

		$item = "identificador";
		$cadena="";
		$valor = $this->identificador;

                      $items = ControladorMenu::ctrEditarMenu($valor,$item);
                      $k=0;
                      $w=1;
					  $z=1;
                     foreach ($items as $key => $value)
                      {
                        $cadena = '<li><i class="fa fa-plus"></i>
                                <label><input id="xnode-'.$k.'" data-id="custom-'.$k.'" type="checkbox" />'.$value["nombreServicio"].'</label>
                                  <ul>
                                    <li> <i class="fa fa-plus"></i>
                                      <label><input  id="xnode-'.$k.'-'.$w.'" data-id="custom-'.$k.'-'.$w.'" type="checkbox" />'.$value["nombreProceso"].'</label>
                                      <ul>';

                                      $operacionSubproceso=explode(",", $value["nombreSub"]);
    
                                        for ($i=0; $i<count($operacionSubproceso); $i++) 
                                            {
                                              $cadena = '<li>
                                                    <label><input class="hummingbirdNoParent" id="xnode-'.$k.'-'.$w.'-'.$z.'" data-id="custom-'.$k.'-'.$w.'-'.$z.'" type="checkbox" />'.$operacionSubproceso[$i].'</label>
                                                    </li>';
                                                    $z++;
                                            }
                                       
                                         
                                    $cadena ='</ul>
                                    </li>
                                  </ul>
                              </li>';
                              $k++;
                              $w++;
                     }
	   
      echo $cadena;
	}

   /*=============================================
	EDITAR SERVICIOS MENU USUARIO
	=============================================*/	

	public $servicios_activos_menu;
    public $user_menu_edit; 
	public function ajaxEditarMenu()
	{
	
		$valor1 = $this->servicios_activos_menu;
        $valor2 = $this->user_menu_edit;
		$respuesta = ControladorMenu::ctrEditarMenuServicio($valor1,$valor2);
		echo json_encode($respuesta);
		//echo $respuesta;	
	}
}

/*=============================================
ACTIVAR SERVICIOS USUARIO
=============================================*/
if(isset($_GET["userMenu"]))
{

	$editar_menu = new AjaxMenu();
	$editar_menu -> servicios_activos_menu = $_POST["servicios_activos_menu"];
	$editar_menu -> user_menu_edit = $_GET["userMenu"];
	$editar_menu -> ajaxEditarMenu();

}

/*=============================================
EDITAR USUARIO
=============================================*/
if(isset($_POST["identificador"])){

	$editar = new AjaxMenu();
	$editar -> identificador = $_POST["identificador"];
	$editar -> ajaxMenuUsuario();

}

/*=============================================
ACTIVAR USUARIO
=============================================*/	

if(isset($_POST["activarUsuario"])){

	$activarUsuario = new AjaxMenu();
	$activarUsuario -> activarUsuario = $_POST["activarUsuario"];
	$activarUsuario -> activarId = $_POST["activarId"];
	$activarUsuario -> ajaxActivarUsuario();

}

/*=============================================
VALIDAR NO REPETIR USUARIO
=============================================*/

if(isset( $_POST["validarUsuario"])){

	$valUsuario = new AjaxUsuarios();
	$valUsuario -> validarUsuario = $_POST["validarUsuario"];
	$valUsuario -> ajaxValidarUsuario();

}