 <?php
 
include "Utils.php"; 

// Clear the cache
//ini_set("soap.wsdl_cache_enabled", 0);

// Service URL
$svcUri = 'https://sms.didimo.es/wcf/Service.svc/soap';
$svc_wsdl = 'https://sms.didimo.es/wcf/Service.svc/soap?wsdl';
$svcMethod = 'GetCertifyFile';

// User data
$username = 'username@domain.com';
$password = 'password'; 

Utils::printr ("service: ".$svcUri." \r\n");
Utils::printr ("username: ".$username." \r\n");
Utils::printr ("****************************************************************************************** \n");

// SOAP Data
$id = '1244eaaa-9cbe-434a-a3eb-762fa8be865f'; #Required

$data = array( 
        'UserName' => $username,
        'Password' => $password,
		'Id' => $id
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
//Check the http code status
if (is_soap_fault($responseMessage)) {
    Utils::printr($responseMessage->faultstring." \r\n");
    if(property_exists($responseMessage, "detail")){
            Utils::printr($responseMessage->detail->string." \r\n");
        }
}
else{
        Utils::printr ($svcMethod." Response:  \r\n");
        Utils::printr ("----------\r\n");
        Utils::printr ($responseMessage);
        
        Utils::printr ("****************************************************************************************** \n");
        
        Utils::printr ("Headers Response: \r\n");
        $headersResponse = explode("\n", $client->__getLastResponseHeaders());
        Utils::printr ($headersResponse);
        
        Utils::printr ("****************************************************************************************** \n");
        
        Utils::printr (" Get the file name:  \r\n");
        Utils::printr ("----------\r\n");
        
        // Get the file name
        $fileName = Utils::GetFileNameFromHeadersResponse($headersResponse, "message_".$id.".pdf");
                
        Utils::printr ("file name: ".$fileName."\r\n");
        
        // Save Certify file on disk
        $fileDirectory = "C:\\SMSCertifies\\sms.didimo\\"; # Put your directory path
        $fullPath = $fileDirectory.$fileName;
        Utils::printr (" Save File:  \r\n");
        Utils::printr ("----------\r\n");
        
        $content = $responseMessage->GetCertifyFileResult;
        
        file_put_contents(trim($fullPath), $content);
        
        Utils::printr ("File saved on: ".$fullPath."\r\n");
        
        Utils::printr ("****************************************************************************************** \n");

}
 ?> 