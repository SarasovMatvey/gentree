<?php

namespace App\Gentree\RawProviders;

use App\Gentree\Dto\RawItem;
use App\Gentree\RawValidators\CsvRawValidator;
use Exception;
use League\Csv\Reader;

class CsvRawProvider implements RawProviderInterface
{
    /**
     * @var Reader|null
     */
    private $csvFile = null;

    /**
     * @param string $path
     *
     * @return void
     *
     * @throws \League\Csv\Exception
     * @throws Exception
     */
    public function addCsvFile(string $path) {
        $validator = new CsvRawValidator();
        $validator->addCsvFile($path);
        $validationResult = $validator->isValid();

        if (!$validationResult->isValid) throw new Exception($validationResult->errorMessage);

        $this->csvFile = Reader::createFromPath($path, 'r');
    }

    /**
     * @inheritdoc
     *
     * @throws \League\Csv\Exception
     */
    public function provideRaw(): array
    {
        if (!$this->csvFile) return [];

        $this->csvFile->setDelimiter($_ENV['CSV_RAW_DATA_DELIMITER']);
        $this->csvFile->setHeaderOffset(0);
        $items = iterator_to_array($this->csvFile->getRecords(['name', 'type', 'parent', 'relation']));

        return array_map(function ($item) {
            return new RawItem($item['name'], $item['type'], $item['parent'], $item['relation']);
        }, $items);
    }
}