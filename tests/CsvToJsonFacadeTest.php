<?php

namespace Tests;

use App\Gentree\Facades\CsvToJsonFacade;

class CsvToJsonFacadeTest extends GentreeTestCase
{
    public function testGenerateTree()
    {
        $realJson = CsvToJsonFacade::generateTree('/home/matvey/work/gentree/tests/fixtures/input.csv');
        $expectedJson = file_get_contents('/home/matvey/work/gentree/tests/fixtures/output.json');

        $this->assertSame(json_decode($expectedJson, true), json_decode($realJson, true), 'Resulting json should be equal to the fixture json');
    }
}
