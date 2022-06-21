<?php

namespace App\Gentree\Serializers;

use App\Gentree\Dto\FormattedItem;

interface SerializerInterface
{
    /**
     * @param FormattedItem[] $formattedItemsTree
     *
     * @return mixed
     */
     public static function serialize(array $formattedItemsTree);
}