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

$code = new StdClass;
$code->AccessibleCarrierCode = "FZ";
$UserData = new StdClass;
$UserData->CarrierCodes = array($code);
$UserData->UserName = "8040010628";
$UserData->Password = "YinxpoooWy";

$url = "https://readingreportservice.xm.com.co/ReadingReportService.svc?wsdl";
$client = new SoapClient($url, $options); 
$result = $client->GetProcessResult(array("processId"=>"64dc3683-e15c-49fa-8981-5e7a8933d89f","userData"=>$UserData));

echo("Result:\n");

print_r($result);

echo "Resultado envio: ".$result->GetProcessResultResult->ResultFlag."</br>";
echo "Frontera:".$result->GetProcessResultResult->Results->BorderResult->Code;

?>

