<?php

use App\Gentree\Dto\FormattedItem;
use App\Gentree\Serializers\JsonSerializer;
use PHPUnit\Framework\TestCase;

class JsonSerializerTest extends TestCase
{
    /**
     * @dataProvider providerSerialize
     */
    public function testSerialize($inputTree, $expectedJsonString, $message)
    {
        $this->assertEquals(json_decode($expectedJsonString, true), json_decode(JsonSerializer::serialize($inputTree), true), $message);
    }

    public function providerSerialize() {
        return [
            [
                [], '[]', 'Empty array'
            ],
            [
                [new FormattedItem('a', 'b', 'c', [])], '[{"itemName": "a", "parent": "b", "children": []}]', 'Item without children'
            ],
            [
                [new FormattedItem('a', 'b', 'c', [
                    new FormattedItem('d', 'e', 'f', [])
                ])], '[{"itemName": "a", "parent": "b", "children": [
                    {"itemName": "d", "parent": "e", "children": []}
                ]}]', 'Item with one children'
            ]
        ];
    }
}