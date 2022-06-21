<?php

namespace App\Gentree\Facades;

use App\Gentree\Gentree;
use App\Gentree\RawProviders\CsvRawProvider;
use App\Gentree\Serializers\JsonSerializer;

class CsvToJsonFacade
{
    public static function generateTree($csvFilePath): string
    {
        $csvRawProvider = new CsvRawProvider();
        $csvRawProvider->addCsvFile($csvFilePath);

        $tree = Gentree::generateTree($csvRawProvider);

        return JsonSerializer::serialize($tree);
    }
}
