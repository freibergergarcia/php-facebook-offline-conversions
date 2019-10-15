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

// Make the Request
$request = new Request($facebook);
$request->delete('{Offline Event Set ID}');

print_r($request->getResponse()->getGraphNode());

exit;
