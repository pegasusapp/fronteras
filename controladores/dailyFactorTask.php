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
                        var_dump(self::ctrAsignamentFactorM($array,$fecha[0],$value["fronteraCliente"],Constantes::SIGLA_SING_CAPACITIVA));
                            }
               $array_p = ControladorFactorM::ctrReportDailyFactorM(Constantes::SIGLA_SING_PENALIZADA,$value["fronteraCliente"],10);
                   if(!empty($array_p)){
                        var_dump(self::ctrAsignamentFactorM($array_p,$fecha[0],$value["fronteraCliente"],Constantes::SIGLA_SING_PENALIZADA));
                            }      
            }
        }

    /**
     * function to asign M factor to frontera
     *
     * @param array $array
     * @param int $year
     * @param string $frontera
     * @param string $tipoe
     * @return array
     */    
    public function ctrAsignamentFactorM($array,$year,$frontera,$tipoe):array{
        $arrayInsertctrFactorM = array(); 
        $arrayResultado = array();
        $factor = 0;
        $arrayResultado +=["frontera"=>$frontera];
        $total=0;
        $flag = false; 
        foreach($array as $value){
          if($value['consumo'] > 10)
                    {
                       if(!$flag)
                       {
                        $factor++;
                        
                       } 
                       $total = $value['cantidad'];
                       $flag = false;
                       
                    }
                    else{
                        $factor =1;
                        $total = $value['cantidad'];
                        $flag = true;
                    }
                    $arrayInsertctrFactorM = array("anyo" =>$year, 
						 "mes"=>$value['mes'],
						 "factor"=>$factor,
						 "total"=>$total,
                         "tipoEnergia"=>$tipoe,
						 "frontera_fronteraCliente"=>$frontera,
                         "dias"=>$value['consumo']); 
                         print("<pre>".print_r($arrayInsertctrFactorM,true)."</pre>");

                   $arrayResultado  += ["resultado"=> ControladorCtrFactorM::ctrCrearctrFactorM($arrayInsertctrFactorM)];
                   
                }   
                
                return $arrayResultado;

            }

        

   
}

parse_str($argv[1], $params);

if (isset($params['days'])) {
    $dias = $params['days'];
    $task = new ControladorReporteFactorM();
    $task -> ctrCalculateFactorM($dias);
    
}