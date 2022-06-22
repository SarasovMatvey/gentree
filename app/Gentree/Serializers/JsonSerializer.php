<?php

namespace App\Gentree\Serializers;

class JsonSerializer implements SerializerInterface
{

    /**
     * @inheritDoc
     *
     * @return string
     */
    public static function serialize(array $formattedItemsTree): string
    {
        return json_encode(self::convertToJsonAsArray($formattedItemsTree), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    private static function convertToJsonAsArray(array $formattedItemsTree)
    {
        $jsonAsArray = [];

        foreach ($formattedItemsTree as $formattedItem) {
            $jsonAsArray[] = [
                'itemName' => $formattedItem->name,
                'parent' => $formattedItem->parent,
                'children' => self::convertToJsonAsArray($formattedItem->children)
            ];
        }


        return $jsonAsArray;
    }
}
