<?php

namespace App\Gentree\RawValidators;

use App\Gentree\Dto\ValidationResult;
use League\Csv\Reader;
use League\Csv\Statement;

class CsvRawValidator implements RawValidatorInterface
{
    /**
     * @var Reader|null
     */
    private $csvFile = null;

    /**
     * @param string $path
     *
     * @return void
     */
    public function addCsvFile(string $path) {
        $this->csvFile = Reader::createFromPath($path, 'r');
    }

    /**
     * @return ValidationResult
     *
     * @throws \League\Csv\Exception
     */
    public function isValid(): ValidationResult
    {
        $this->csvFile->setDelimiter($_ENV['CSV_RAW_DATA_DELIMITER']);
        $this->csvFile->setHeaderOffset(0);

        $stmt = new Statement();
        $fileInfo = $stmt->process($this->csvFile);

        $realHeaders = $fileInfo->getHeader();
        $expectedHeaders = [
            'Item Name',
            'Type',
            'Parent',
            'Relation'
        ];
        if ($realHeaders !== $expectedHeaders) {
            return new ValidationResult(false, 'File headers are not correct');
        }

        if($fileInfo->count() > $_ENV['RAW_DATA_MAX_ROWS']) {
            return new ValidationResult(false, "File contains too many entries ({$_ENV['RAW_DATA_MAX_ROWS']})");
        }

        return new ValidationResult(true);
    }
}