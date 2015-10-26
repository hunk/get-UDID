<?php
//get data
$data = file_get_contents('php://input');

//extract XML from data
$plistBegin   = '<?xml version="1.0"';
$plistEnd   = '</plist>';

$pos1 = strpos($data, $plistBegin);
$pos2 = strpos($data, $plistEnd);
$data2 = substr ($data,$pos1,$pos2-$pos1);


$xml = xml_parser_create();
xml_parse_into_struct($xml, $data2, $vs);
xml_parser_free($xml);

$UDID = "";
$DEVICE_PRODUCT = "";
$DEVICE_VERSION = "";
$DEVICE_NAME = "";
$iterator = 0;

$arrayCleaned = array();
foreach($vs as $v){

    if($v['level'] == 3 && $v['type'] == 'complete'){
        $arrayCleaned[]= $v;
    }
    $iterator++;
}

$iterator = 0;
foreach($arrayCleaned as $elem){
    switch ($elem['value']) {
        case "UDID":
            $UDID = $arrayCleaned[$iterator+1]['value'];
            break;
        case "PRODUCT":
            $DEVICE_PRODUCT = $arrayCleaned[$iterator+1]['value'];
            break;
        case "VERSION":
            $DEVICE_VERSION = $arrayCleaned[$iterator+1]['value'];
            break;
        case "DEVICE_NAME":
            $DEVICE_NAME = $arrayCleaned[$iterator+1]['value'];
            break;
    }
    $iterator++;
}

$params = "UDID=".$UDID."&DEVICE_PRODUCT=".$DEVICE_PRODUCT."&DEVICE_VERSION=".$DEVICE_VERSION."&DEVICE_NAME=".$DEVICE_NAME;
header("Location: show_detail.php?".$params,TRUE,301);