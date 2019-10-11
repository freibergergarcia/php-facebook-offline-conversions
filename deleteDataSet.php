<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Acme\Csv;
use Acme\DeleteOfflineConversion;
use Acme\FacebookConnector;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env', __DIR__ . '/.env.dev');

$filePath = __DIR__ . '/assets/csv/DEFAULT-DEMO.csv';
$file = new Csv($filePath);
$facebook = new FacebookConnector();

$offlineConversion = new DeleteOfflineConversion($facebook);
$offlineConversion->setDataSet('{REPLACE WITH THE DATASET ID}')
    ->sendRequest();

$results = $offlineConversion->getResponse();
$graphNode = $results->getGraphNode();

var_dump($graphNode);
