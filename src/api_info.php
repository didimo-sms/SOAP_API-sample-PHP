<?php

include "Utils.php"; 

// Clear the cache
//ini_set("soap.wsdl_cache_enabled", 0);

// Service URL
$svcUri = 'https://sms.didimo.es/wcf/Service.svc/soap';
$svc_wsdl = 'https://sms.didimo.es/wcf/Service.svc/soap?wsdl';

$info=array( 'soap_version'=> SOAP_1_1,
             'trace'=>1,
             'exceptions'=>0,
             'location' => $svcUri,
             'uri'=> $svcUri); 

$client = new SoapClient($svc_wsdl, $info);

Utils::printr($svcUri."\r\n");
Utils::printr("********************************************************************************************* \r\n");

Utils::printr ($client->__getFunctions());
Utils::printr("********************************************************************************************* \r\n");

Utils::printr($client->__getTypes());
Utils::printr("********************************************************************************************* \r\n");


?>


