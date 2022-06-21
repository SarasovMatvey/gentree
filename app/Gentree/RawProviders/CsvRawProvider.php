<?php

namespace App\Gentree\RawProviders;

use App\Gentree\Dto\RawItem;
use League\Csv\Reader;

class CsvRawProvider implements RawProviderInterface
{
    private $csvFile = null;

    /**
     * @param string $path
     *
     * @return void
     *
     * @throws \League\Csv\Exception
     */
    public function addCsvFile(string $path) {
        // TODO: handle open file error
        $this->csvFile = Reader::createFromPath($path, 'r');
    }

    /**
     * @inheritdoc
     */
    public function provideRaw(): array
    {
        if (!$this->csvFile) return [];

        $this->csvFile->setDelimiter(';');
        $this->csvFile->setHeaderOffset(0);
        $items = iterator_to_array($this->csvFile->getRecords(['name', 'type', 'parent', 'relation']));

        return array_map(function ($item) {
            return new RawItem($item['name'], $item['type'], $item['parent'], $item['relation']);
        }, $items);
    }
}