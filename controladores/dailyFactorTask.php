<?php

require "logLecturaWS.controlador.php";
require dirname(__FILE__)."/../modelos/logLecturaWS.modelo.php";
require dirname(__FILE__)."/../modelos/fronteras.modelo.php";
require dirname(__FILE__)."/../modelos/factorm.modelo.php";
require dirname(__FILE__)."/../modelos/ctrfactorm.modelo.php";
require "utilidades.controlador.php";
require "constantes.controlador.php";
require "factorm.controlador.php";
require "ctrfactorm.controlador.php";
class ControladorReporteFactorM{

    public function ctrCalculateFactorM($dias){
        $fecha = explode("-",ControladorUtilidades::anyoMesDia($dias));	
        $fronteras = ModeloFronteras::mdlMostrarFronteras("frontera","","");
        foreach ($fronteras as $value){
               $array = ControladorFactorM::ctrReportDailyFactorM(Constantes::SIGLA_SING_CAPACITIVA,$value["fronteraCliente"],10);
               var_dump($array);
               if(!empty($array)){
                   echo self::ctrAsignamentFactorM($array,$fecha[0],$fecha[1]);
                            }
            }
        }

    public function ctrAsignamentFactorM($array,$year,$month):array{
        $arrayInsertctrFactorM = array(); 
        $arrayResultado = array();
        $factor = 0;
        $arrayResultado +=["frontera"=>$array["frontera_fronteraCliente"]];
        for($i=1;$i<=$month;$i++){

                    if((array_key_exists('mes',$array) && $array['mes'] == $i) && (array_key_exists('anyo',$array) && $array['anyo'] == $year))
                    {
                         $factor++;   
                    }
                    else{
                        $factor =1;
                    }
                       

                    $arrayInsertctrFactorM = array("anyo" =>$year, 
						 "mes"=>$month,
						 "factor"=>$i,
						 "total"=>$array["total"],
						 "frontera_fronteraCliente"=>$array["frontera_fronteraCliente"]); 

                   $arrayResultado  += ["frontera"=> ControladorCtrFactorM::ctrCrearctrFactorM($arrayInsertctrFactorM)];
                   
                }   
                
                return $arrayResultado;

            }

        

   
}

//parse_str($argv[1], $params);

//if (isset($params['days'])) {
    $dias = $_GET["days"];
    $task = new ControladorReporteFactorM();
    $task -> ctrCalculateFactorM($dias);
    
//}