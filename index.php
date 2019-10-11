<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Acme\Csv;
use Acme\FacebookConnector;
use Acme\Model\DataFactory;
use Acme\OfflineConversion;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env', __DIR__ . '/.env.dev');

// Initialize FB
$facebook = new FacebookConnector();

// Build Sale Object
$saleFilePath = __DIR__ . '/assets/csv-example/SALEHEADER.csv';
$saleHeader = new Csv($saleFilePath);

// Build Sale Line Object
$saleLineFilePath = __DIR__ . '/assets/csv-example/SALELINE.csv';
$saleLine = new Csv($saleLineFilePath);

// Build Data
$offlineData = new DataFactory($saleHeader, $saleLine);
$offlineData->buildSale();
$offlineData->getDataSetContent();
$jsonToGo = $offlineData->dataSetToJson();

// Post Request
$sendDataToFb = new OfflineConversion($facebook);
$sendDataToFb->post($jsonToGo);

// Show Response
var_dump($sendDataToFb->getResponse()->getGraphNode());
