<?php


function dp_set($host, $port, $protocol, $endpoint, $body) {

$protocol = strtolower($protocol);
$url = "$protocol://$host:$port/$endpoint";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$body = '{"whois":"php_test_client","user":"","set":[' . $body . ']}';

curl_setopt($curl, CURLOPT_POSTFIELDS, $body);


$resp = curl_exec($curl);
curl_close($curl);

$arr = json_decode($resp, true);


return $arr;

}

function dp_get($host, $port, $tag, $protocol, $endpoint, $body) {

    $protocol = strtolower($protocol);
    $url = "$protocol://$host:$port/$endpoint";
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $headers = array(
       "Content-Type: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
    if ($tag != "") {
        $tag = '"tag":"' . $tag . '"';
    }
    
    curl_setopt($curl, CURLOPT_POSTFIELDS, '{"tag":"' . $tag . '", "get":[' . $body . ']}');
    
    
    $resp = curl_exec($curl);
    curl_close($curl);
    
    $arr = json_decode($resp, true);
    
    
    return $arr;

    }

function dp_rename($host, $port, $protocol, $endpoint, $body) {

    $protocol = strtolower($protocol);
    $url = "$protocol://$host:$port/$endpoint";
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $headers = array(
        "Content-Type: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
    $body = '{"whois":"php_test_client","user":"","rename":[' . $body . ']}';

    curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    
    
    $resp = curl_exec($curl);
    curl_close($curl);
    
    $arr = json_decode($resp, true);
    
    
    return $arr;

    }

function dp_copy($host, $port, $protocol, $endpoint, $body) {

    $protocol = strtolower($protocol);
    $url = "$protocol://$host:$port/$endpoint";
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $headers = array(
        "Content-Type: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
    $body = '{"whois":"php_test_client","copy":[' . $body . ']}';

    curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    
    
    $resp = curl_exec($curl);
    curl_close($curl);
    
    $arr = json_decode($resp, true);
    
    
    return $arr;

}

function dp_delete($host, $port, $protocol, $endpoint, $body) {

    $protocol = strtolower($protocol);
    $url = "$protocol://$host:$port/$endpoint";
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $headers = array(
        "Content-Type: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
    $body = '{"whois":"php_test_client","delete":[' . $body . ']}';

    curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    
    
    $resp = curl_exec($curl);
    curl_close($curl);
    
    $arr = json_decode($resp, true);
    
    
    return $arr;

}
