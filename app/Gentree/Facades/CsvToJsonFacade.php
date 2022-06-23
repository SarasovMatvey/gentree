<?php

namespace App\Gentree\Facades;

use App\Gentree\Gentree;
use App\Gentree\RawProviders\CsvRawProvider;
use App\Gentree\Serializers\JsonSerializer;

/**
 * Facade for generation input csv file to formatted json string
 */
class CsvToJsonFacade
{
    /**
     * @param $csvFilePath
     *
     * @return string
     *
     * @throws \League\Csv\Exception
     */
    public static function generateTree($csvFilePath): string
    {
        $csvRawProvider = new CsvRawProvider();
        $csvRawProvider->addCsvFile($csvFilePath);

        $gentree = new Gentree();
        $tree = $gentree->generateTree($csvRawProvider);

        return JsonSerializer::serialize($tree);
    }
}
