<?php

require "logLecturaWS.controlador.php";
require dirname(__FILE__)."/../modelos/logLecturaWS.modelo.php";
require dirname(__FILE__)."/../modelos/fronteras.modelo.php";
require "utilidades.controlador.php";
require "constantes.controlador.php";


class ControladorFronterasWS{ 

     public function ctrPrepareDataToSendWS(){

                
        $fecha = explode("-",ControladorUtilidades::anyoMesDia(1));	
        $fronteras = ModeloFronteras::mdlMostrarFronteras("frontera","","");
        $resultado_gral = array(); 
        foreach ($fronteras as $value){
               $array = self::ctrConexionLecturasFronteraWS($fecha[0],$fecha[1],$fecha[2],$value["fronteraCliente"]);
               if(!empty($array)){
                   $resultado = "OK";
                   $fechaParser = $fecha[0]."-".$fecha[1]."-".$fecha[2];
                   if(!self::ctrSendToSaveDataFronteraWS($array,$fecha[0],$fecha[1],$fecha[2]))
                   {
                       $resultado = "ERROR";
                   }
                   $datosLog = array("fechaLectura" =>$fechaParser,"frontera"=>$value["fronteraCliente"],"resultado"=>$resultado);
                   ControladorLogLecturaWS::ctrCrearLogLecturaWS($datosLog);
                   $resultado_gral +=$datosLog; 
                   
               }
           }
           ControladorUtilidades::sendMail("Reporte diario de lecturas","oscar.2001601@gmail.com","Estas son las lecturas del día $resultado_gral");
       }

                    
        public function ctrConexionLecturasFronteraWS($anyo,$mes,$dia,$frontera):array{
        
           $requestXML="<methodCall>
           <methodName>execute_kw</methodName>
           <params>
               <param>
                   <value>
                       <string>medicion</string>
                   </value>
               </param>
               <param>
                   <value>
                       <int>".Constantes::USER_WS."</int>
                   </value>
               </param>
               <param>
                   <value>
                       <string>".Constantes::PASSW_WS."</string>
                   </value>
               </param>
               <param>
                   <value>
                       <string>".Constantes::DIRIN_WS."</string>
                   </value>
               </param>
               <param>
                   <value>
                       <string>".Constantes::NAME_WS."</string>
                   </value>
               </param>
               <param>
                   <value>
                       <array>
                           <data>
                               <value>
                               </value>
                           </data>
                           <data>
                               <value>
                                   <struct>
                                       <member>
                                           <name>ano</name>
                                           <value>
                                               <int>$anyo</int>
                                           </value>
                                       </member>
                                       <member>
                                           <name>mes</name>
                                           <value>
                                               <int>$mes</int>
                                           </value>
                                       </member>
                                       <member>
                                           <name>dia</name>
                                           <value>
                                               <int>$dia</int>
                                           </value>
                                       </member>
                                       <member>
                                           <name>codigosic</name>
                                           <value>
                                               <string>$frontera</string>
                                           </value>
                                       </member>								
                                   </struct>
                               </value>
                           </data>
                       </array>
                   </value>
               </param>
           </params>
           </methodCall>";
    
           $server = Constantes::URL_WS;
           $headers = [
               "Content-type: text/xml",
               "Content-length: " . strlen($requestXML), "Connection: close",
           ];
           $ch = curl_init();
           curl_setopt($ch, CURLOPT_URL, $server);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
           curl_setopt($ch, CURLOPT_TIMEOUT, 100);
           curl_setopt($ch, CURLOPT_POST, true);
           curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXML);
           curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
           $data = curl_exec($ch);
           $array =  json_decode(json_encode(simplexml_load_string($data)),true);
           $arrayFinish = array();
           if(sizeof($array["params"]["param"]["value"]["struct"]) === 1)
           {
               $total = $array["params"]["param"]["value"]["struct"]["member"]["value"]["array"]["data"]["value"];
               $i=0;
               $arrayFinish = array();
               foreach($total as $valor)
               {
       
                   $traceo = $valor["struct"]["member"];
                   $arrayInterno = array();
                   foreach($traceo as $value)
                    {
                        $arrayInterno += [$value["name"] =>array_shift($value["value"])];
                    }
                   $resultado = array_merge($arrayInterno);
                   $arrayFinish += array($i => $resultado);
                   $i++;
               }
           }
           
           
           return $arrayFinish;
       }
    
        public function ctrSendToSaveDataFronteraWS($datos,$anyo,$mes,$dia):bool{
    
           $datosLecturasEnergiaActiva = array();
           $datosLecturasEnergiaExportada = array();
           $datosLecturasEnergiaCapacitiva = array();
           $datosLecturasEnergiaReactiva = array();
           $datosLecturasEnergiaPenalizada = array();
    
           foreach($datos as $value){
    
                   $medidor = $value["medidor"];
                   $frontera =  $value["codigosic"];
    
                   if($value["canal"] === Constantes::SIGLA_ACTIVA){
                       $datosLecturasEnergiaActiva =  self::ctrChargeArrayEnergyType($value,"A");
                      }
                   elseif($value["canal"] === Constantes::SIGLA_REACTIVA){
                       $datosLecturasEnergiaReactiva = self::ctrChargeArrayEnergyType($value,"R");
                   }
                   elseif($value["canal"] === Constantes::SIGLA_CAPACITIVA){
                       $datosLecturasEnergiaCapacitiva = self::ctrChargeArrayEnergyType($value,"C");
                   }
                   elseif($value["canal"] === Constantes::SIGLA_EXPORTADA){
                       $datosLecturasEnergiaExportada = self::ctrChargeArrayEnergyType($value,"E");
                   }
    
             }
             //check if exist energy penalty
             $datosLecturasEnergiaPenalizada = self::ctrChargePenaltyEnergy($datosLecturasEnergiaActiva,$datosLecturasEnergiaReactiva);
    
             var_dump($datosLecturasEnergiaPenalizada);
             $datosMedidor = array("diaLectura"=>$dia, 
                                                "mesLectura"=>$mes, 
                                                "anyoLectura"=>$anyo, 
                                                "medidorFrontera"=>$medidor, 
                                                "frontera_fronteraCliente"=>$frontera,
                                                "tipoMedidor"=>"P",
                                                "fechaCompleta"=>$anyo.'-'.$mes.'-'.$dia);
    
    
       return ModeloFronteras::mdlInsertLecturasFrontera($datosMedidor,$datosLecturasEnergiaActiva,$datosLecturasEnergiaExportada,$datosLecturasEnergiaReactiva,$datosLecturasEnergiaCapacitiva,$datosLecturasEnergiaPenalizada);
    
       }
    
        public function ctrChargeArrayEnergyType($vector,$siglaTenergy):array{
           $datosBack = array();
    
           $datosBack +=["tipoEnergia"=>$siglaTenergy];
           $j=0; 
           for($i = 1; $i <= 24;$i++)
            {
               $datosBack += ["H".$i => $vector["hora".$j]];
               $j++;
            }
          return $datosBack;
       }

       public function ctrCalculePenalty($vlrActive,$vlrReactive):int{
     
        $operacion_a = $vlrActive*0.5;
        $vlrHoraPenalizada =0;
        if($vlrReactive > $operacion_a)
        {
            $vlrHoraPenalizada = $vlrReactive - $operacion_a;
        }

        return $vlrHoraPenalizada;

       }

       public function ctrChargePenaltyEnergy($arrayActiva,$arrayReactiva):array{
        $datosArrayPenalizadaBack = array();
        $datosArrayPenalizadaBack +=["tipoEnergia"=>"P"];
        $i = 1;
            foreach ($arrayActiva as $key => $valueActiva){
                 if($key<>"tipoEnergia"){
                    $vlrTx = self::ctrCalculePenalty($valueActiva,$arrayReactiva[$key]);
                    $datosArrayPenalizadaBack += ["H".$i => $vlrTx];
                    $i++;
                 }
               
            }
        return $datosArrayPenalizadaBack;
       }



}
$task = new ControladorFronterasWS();
$task -> ctrPrepareDataToSendWS();

?>