<?php
require 'vendor/autoload.php';
use MongoDB\Client;

$client = new Client("mongodb://localhost:27017");//MongoDB数据库地址

$mode = $_GET['mode'];
$random = $_GET['random'];
$longurl = $_GET['longurl'];
$ip = $_GET['ip'];
$code = $_GET['code'];

$codeData = file_get_contents('data/code.json');
$codeData = json_decode($codeData, true);

if ($code !== $codeData['code']) {
    echo "Invalid code";
    exit;
}

if ($mode === 'input') {
    $db = $client->whaleblue_shortlink;
    $collection = $db->urls;
    $document = [
        'random' => $random,
        'longurl' => $longurl,
        'ip' => $ip
    ];
    $collection->insertOne($document);
    echo "Data inserted successfully";
} elseif ($mode === 'output') {
    $db = $client->whaleblue_shortlink;
    $collection = $db->urls;
    $document = $collection->findOne(['random' => $random]);
    if ($document) {
        echo $document['longurl'];
    } else {
        echo "No data found";
    }
} else {
    echo "Invalid mode";
}
