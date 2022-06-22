<?php

use App\Gentree\Facades\CsvToJsonFacade;

require_once 'vendor/autoload.php';


// var_dump(json_decode(file_get_contents('/home/matvey/work/gentree/tests/fixtures/output.json')));
var_dump(json_decode(CsvToJsonFacade::generateTree('/home/matvey/work/gentree/tests/fixtures/input.csv')));

//
//$json = CsvToJsonFacade::generateTree('input.csv');
//
//$outputFile = fopen('/gentree/hostdir/output.json', 'w');
//fwrite($outputFile, $json);
