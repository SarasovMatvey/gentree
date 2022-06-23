<?php

namespace App\Gentree\Serializers;

use App\Gentree\Dto\FormattedItem;

/**
 * Interface for serialization items tree to different (json, txt, etc.)
 */
interface SerializerInterface
{
    /**
     * @param FormattedItem[] $formattedItemsTree
     *
     * @return mixed
     */
     public static function serialize(array $formattedItemsTree);
}