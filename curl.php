<?php
header('Content-type: application/xml');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: SOAPAction, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_POST)) {

    $soapUrl = $_POST['soapUrl'];
    $soapMethod = $_POST['soapMethod'];
    $soapBody = $_POST['soapBody'];

    if (empty($soapUrl) || empty($soapMethod) || empty($soapBody)) {
        $errorXml = '<error>Please check required fields before submiting!</error>';
        print($errorXml);
    }

    $headers = array();

    foreach ($_POST as $key => $value) {
        if($key == "soapContentType"){
            $headers[] = "Content-type: $value";
        }elseif($key == "soapAccept"){
            $headers[] = "Accept: $value";
        }elseif($key == "soapUserkey"){
            $headers[] = "user-key: $value";
        }elseif($key == "soapUrl"){
            $headers[] = "SOAPAction: $value";
        }
    }


    // xml post structure
    $xml_post_string = $soapBody;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_URL, $soapUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

    if ($_POST['soapUserid'] && $_POST['soapUserpass']) {
        $headers[] = 'Authorization: Basic '. base64_encode($_POST['soapUserid'] . ":" . $_POST['soapUserpass']);
    }

    if ($soapMethod == "POST") {
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
    }elseif($soapMethod == "GET"){
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET');
    }
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // converting
    $response = curl_exec($ch); 
    curl_close($ch);

    print($response);
}

?>