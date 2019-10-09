<?php
require_once __DIR__ . '/vendor/autoload.php';

use Acme\Csv;
use Acme\DeleteOfflineConversion;
use Acme\FacebookConnector;
use Symfony\Component\Dotenv\Dotenv;


$test = explode("-", "CKbrunogarcia@pvhba.com", 2);

echo (count($test) > 1) ? $test[1] : $test[0];

var_dump($test);

exit;


$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env', __DIR__ . '/.env.dev');

$filePath = __DIR__ . '/assets/csv/DEFAULT-DEMO.csv';

$file = new Csv($filePath);
$facebook = new FacebookConnector();

$offlineConversion = new DeleteOfflineConversion($facebook);
$offlineConversion->setDataSet('531745504239124')
    ->sendRequest();

$results = $offlineConversion->getResponse();
$graphNode = $results->getGraphNode();

var_dump($graphNode);
