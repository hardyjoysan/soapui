<?php 
    $soapUrl = "https://se-qa-api.volvocars.biz/wsh/services/RealTime/VINLookup";

    // xml post structure
    $xml_post_string = '<?xml version="1.0" encoding="UTF-8"?>
                        <soap:Envelope
                        xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
                        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                        xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                        <soap:Body>
                            <ns0:VINLookup
                            xmlns:ns0="http://vinlookup.vdw.enterprise.volvocars.net">
                            <ns0:VIN>YV1AS982181070907</ns0:VIN>
                            <ns0:License_Plate></ns0:License_Plate>
                            </ns0:VINLookup>
                        </soap:Body>
                        </soap:Envelope>';

    $headers = array(
                "Content-type: application/xml;charset=\"utf-8\"",
                "Accept: application/xml",
                "Cache-Control: no-cache",
                "Pragma: no-cache",
                "SOAPAction: $soapUrl",
                "user-key: 354426404da2912ae76500f02a8ab026",
                "Content-length: ".strlen($xml_post_string),
            );

    $url = $soapUrl;
    // PHP cURL  for https connection with auth
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // converting
    $response = curl_exec($ch); 
    curl_close($ch);

    // converting
    //$response1 = str_replace("<soap:Body>","",$response);
    //$response2 = str_replace("</soap:Body>","",$response1);

    // convertingc to XML
    $parser = simplexml_load_string($response);
    // user $parser to get your data out of XML response and to display it.

    echo '<textarea rows="10">='.$response.'</textarea>';
?>