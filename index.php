<?php

use App\Gentree\Facades\CsvToJsonFacade;
use Symfony\Component\Dotenv\Dotenv;

require_once 'vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$json = CsvToJsonFacade::generateTree('input.csv');

$outputFile = fopen('/gentree/hostdir/output.json', 'w');
fwrite($outputFile, $json);
