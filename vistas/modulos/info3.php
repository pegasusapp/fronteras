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
$result = $client->GetBorderStatus(array("userData"=>$UserData));

echo("Result:\n");

print_r($result);


?>

