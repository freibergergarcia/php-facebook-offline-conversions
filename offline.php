<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Acme\Csv;
use Acme\FacebookConnector;
use Acme\Request;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env', __DIR__ . '/.env.dev');

// Initialize FB
$facebook = new FacebookConnector();

// Build Sale Object
$saleFilePath = __DIR__ . '/assets/csv-example/SALEHEADER.csv';
$saleHeader = new Csv($saleFilePath);

// Build Sale Line Object
$saleContentsFilePath = __DIR__ . '/assets/csv-example/SALELINE.csv';
$saleContents = new Csv($saleContentsFilePath);

// Make the Request
$request = new Request($facebook, $saleHeader, $saleContents);
$request->build();
$request->post();

print_r($request->getResponse()->getGraphNode());

exit;
