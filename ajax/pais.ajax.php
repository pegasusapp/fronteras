<?php
require_once "../modelos/pais.modelo.php";

class AjaxPais
{
    public $pais;
    public $dpto;
    public function ajaxListPais()
    {
        
        $tabla = "pais";
        $item = null;
        $valor = null;
        $respuesta = ModeloPais::mdlMostrarPais($tabla,$item,$valor); 
        echo json_encode($respuesta);
    }
    public function ajaxListDpto()
    {
        
        $tabla = "departamento";
        $item = pais_idpais;
        $valor = $this->pais;
        $respuesta = ModeloPais::mdlMostrarDepartamento($tabla,$item,$valor); 
        echo json_encode($respuesta);
    }

    public function ajaxListMunicpio()
    {
        
        $tabla = "municipio";
        $item = departamento_iddepartamento;
        $valor = $this->dpto;
        $respuesta = ModeloPais::mdlMostrarMunicipio($tabla,$item,$valor); 
        echo json_encode($respuesta);
    }

}

if(isset($_POST["listado_pais"]))
	{
		$total_c = new AjaxPais();
		$total_c -> ajaxListPais();
    }
if(isset($_POST["valorDpto"]))
	{
		$total_d = new AjaxPais();
		$total_d -> pais = $_POST["valorDpto"];
		$total_d -> ajaxListDpto();
    }
if(isset($_POST["valorMunicipio"]))
	{
		$total_m = new AjaxPais();
		$total_m -> dpto = $_POST["valorMunicipio"];
		$total_m -> ajaxListMunicpio();
	}         