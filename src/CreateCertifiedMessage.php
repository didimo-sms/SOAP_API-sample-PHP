 <?php 

 include "Utils.php"; 

// Clear the cache
//ini_set("soap.wsdl_cache_enabled", 0);

// Service URL
$svcUri = 'https://sms.didimo.es/wcf/Service.svc/soap';
$svc_wsdl = 'https://sms.didimo.es/wcf/Service.svc/soap?wsdl';
$svcMethod = 'CreateCertifiedMessage';

// User data
$username = 'username@domain.com';
$password = 'password'; 

Utils::printr ("service: ".$svcUri." \r\n");
Utils::printr ("username: ".$username." \r\n");
Utils::printr ("****************************************************************************************** \n");

// SOAP Data
$name = 'Test SOAP API - PHP Client -'.date("Y-m-d H:i:s"); #Optional
$scheduleDate = date("Y-m-d\TH:i:s"); #Optional
$sender = 'sender'; #Optional
$id=Utils::CreateGUID(); #Optional
$isUnicode='false';  #Optional - Values: 'true' or 'false'. Default value: 'false'
$mobile='+34653695688'; #Required
$text='Test API SMS Certificado sms.didimo.es, by PHP client '.date("Y-m-d H:i:s").' - '.$id; #Required
$date= date("Y-m-d\TH:i:s"); #Optional Format: yyyy-MM-ddTHH:mm:ss

$data = array( 
            'UserName' => $username,
            'Password' => $password,
            'Id' => $id,
            'IsUnicode' => $isUnicode,
            'Mobile' => $mobile,
            'Name' => $name,
            'ScheduleDate' => $date,
            'Sender' => $sender,
            'Text' => $text,
            );

Utils::printr ("Parameters  \r\n");
Utils::printr ("----------\r\n");
Utils::printr($data);
Utils::printr ("****************************************************************************************** \n");

// SOAP Client data
$info=array( 'soap_version'=> SOAP_1_1,
             'trace'=>1,
             'exceptions'=>0,
             'location' => $svcUri,
             'uri'=> $svcUri); 

$client = new SoapClient($svc_wsdl, $info);

Utils::printr("Client:  \r\n");
Utils::printr( $client);
Utils::printr ("****************************************************************************************** \n");

Utils::printr ("Call to ".$svcMethod."...  \r\n");

$responseMessage = $client->__soapCall($svcMethod,array('parameters' => array("inputdata" => $data)));

Utils::printr ("...  \r\n");
Utils::printr ("SOAP Request:  \r\n");
Utils::printr(htmlentities($client->__getLastRequest()));
Utils::printr ("****************************************************************************************** \n");

Utils::printr ("...  \r\n");

// Result
Utils::printr ($svcMethod." Response:  \r\n");
Utils::printr ("----------\r\n");
Utils::printr ($responseMessage);
Utils::printr ("****************************************************************************************** \n");

 ?> 