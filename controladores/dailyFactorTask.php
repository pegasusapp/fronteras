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
               if(!empty($array)){
                   echo "<br>"; 
                   var_dump(self::ctrAsignamentFactorM($array,$fecha[0],$fecha[1],$value["fronteraCliente"]));
                            }
            }
        }

    public function ctrAsignamentFactorM($array,$year,$month,$frontera):array{
        $arrayInsertctrFactorM = array(); 
        $arrayResultado = array();
        $factor = 0;
        $arrayResultado +=["frontera"=>$frontera];
        $j=0;
        $total=0;
        for($i=1;$i<=$month;$i++){

                    if(($array[$j]['mes'] == $i) && ($array[$j]['anyo'] == $year))
                    {
                        $factor++;
                        $total = $array[$j]["cantidad"];
                    }
                    else{
                        $factor =1;
                        echo "no existe";
                    }
                       
                    $j++;  
                    $arrayInsertctrFactorM = array("anyo" =>$year, 
						 "mes"=>$i,
						 "factor"=>$factor,
						 "total"=>$total,
						 "frontera_fronteraCliente"=>$frontera); 

                         $var_dump($arrayInsertctrFactorM);

                   $arrayResultado  += ["resultado"=> ControladorCtrFactorM::ctrCrearctrFactorM($arrayInsertctrFactorM)];
                   
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