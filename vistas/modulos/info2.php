<?php  
ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);
$options = array(
    'cache_wsdl' => 0,
    'trace' => 1,
    'stream_context' => stream_context_create(
        array(
          'ssl' => array(
                          'verify_peer' => false,
                          'verify_peer_name' => false,
                          'allow_self_signed' => true
                        )
          )
          ));
error_reporting(E_ALL);
ini_set('display_errors', '1');
//fecha del dia
$fecha_actual = date("Y-m-d");

//generamos la clase para enviar credenciales
$code = new StdClass;
$code->AccessibleCarrierCode = "FZ";
$UserData = new StdClass;
$UserData->CarrierCodes = array($code);
$UserData->UserName = "8040010628";
$UserData->Password = "YinxpoooWy";
//fin

//preparamos la consulta para extraer los datos de la BD
$valor="Frt36362";
$energia="A"; 
$items = ControladorFronteras::ctrConsultarFronteraReportarXM($valor,$energia);
foreach ($items as $key => $value)
{

//preparamos los parametros para el envio de las lecturas a XM
$params = array(
              'readings'=>array(
                                  'ReadingReportItem' => array(
                                                            'BorderCode'=>$value["frontera_fronteraCliente"],
                                                            'IsBackup'=>false,
                                                            'ReadingCount'=>24,
                                                            'ReadingInterval'=>60,
                                                            'Readings'=>array($value["H1"],$value["H2"],$value["H3"],$value["H4"],$value["H5"],$value["H6"],$value["H7"],$value["H8"],$value["H9"],$value["H10"],$value["H11"],$value["H12"],$value["H13"],$value["H14"],$value["H15"],$value["H16"],$value["H17"],$value["H18"],$value["H19"],$value["H20"],$value["H21"],$value["H22"],$value["H23"],$value["H24"]),
                                                            'StartDate'=> date("Y-m-d",strtotime($fecha_actual."- 1 days"))
                                                            )
                                  ),
               'userData'=>$UserData                                             
              );
}

print_r($params);
//fin
         
//invocamos el WS
$url = "https://readingreportservice.xm.com.co/ReadingReportService.svc?wsdl";
//pasamos las opciones
$client = new SoapClient($url, $options); 
// enviamos los parametros
$result = $client->ReportReadings($params); 
echo("Result:\n");
print_r($result);

?>

