<?php

use App\Gentree\Facades\CsvToJsonFacade;
use App\Gentree\RawValidators\CsvRawValidator;

require_once 'vendor/autoload.php';

//$json = CsvToJsonFacade::generateTree('input.csv');
//
//$outputFile = fopen('/gentree/hostdir/output.json', 'w');
//fwrite($outputFile, $json);

$v = new CsvRawValidator();
$v->addCsvFile('input.csv');
var_dump($v->isValid());
