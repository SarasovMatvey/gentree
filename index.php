<?php

use App\Gentree\Facades\CsvToJsonFacade;

require_once 'vendor/autoload.php';

$json = CsvToJsonFacade::generateTree('input.csv');

$outputFile = fopen('/gentree/hostdir/output.json', 'w');
fwrite($outputFile, $json);
