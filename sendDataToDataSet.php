<?php
require_once __DIR__ . '/vendor/autoload.php';

use Acme\Csv;
use Acme\FacebookConnector;
use Acme\PostOfflineConversion;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env', __DIR__.'/.env.dev');

$filePath = __DIR__ . '/assets/csv/DEFAULT-DEMO.csv';

$file = new Csv($filePath);
$facebook = new FacebookConnector();

$offlineConversion = new PostOfflineConversion($facebook, $file);
$offlineConversion->sendRequest();


$results = $offlineConversion->getResponse();
$graphNode = $results->getGraphNode();

var_dump($graphNode);
