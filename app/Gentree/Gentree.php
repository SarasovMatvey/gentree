<?php

namespace App\Gentree;

use App\Gentree\Dto\FormattedItem;
use App\Gentree\Dto\RawItem;
use App\Gentree\RawProviders\RawProviderInterface;
use function array_key_exists;
use function array_keys;
use function array_map;
use function fopen;
use function fwrite;
use function json_decode;
use function json_encode;
use function var_dump;
use const JSON_PRETTY_PRINT;
use const JSON_UNESCAPED_UNICODE;

/**
 * Class for generating json tree from csv file
 */
class Gentree
{
    /**
     * @var $indexOfAllRawItems array<string, RawItem>
     */
    private $indexOfAllRawItems = [];

    /**
     * @var $indexOfSameLayerRawItemsGroups array<string, RawItem>
     */
    private $indexOfSameLayerRawItemsGroups = [];

    /**
     * @param $dataProvider RawProviderInterface
     *
     * @reture FormattedItem[]
     */
    public function generateTree($dataProvider): array
    {
        $raw = $dataProvider->provideRaw();

        foreach ($raw as $rawItem) {
            $this->indexOfAllRawItems[$rawItem->name] = $rawItem;
            $this->indexOfSameLayerRawItemsGroups[$rawItem->parent][] = $rawItem;
        }


        return self::generateRecursive('');
    }

    /**
     * @param $prerequisites array
     * @param $startRawItemName string
     * @param $rewritableParentName string|null
     *
     * @return Dto\FormattedItem[]
     */
    private function generateRecursive(string $startRawItemName, string $rewritableParentName = null): array
    {
        /** @var  $tree FormattedItem[] */
        $tree = [];

        if (!array_key_exists($startRawItemName, $this->indexOfSameLayerRawItemsGroups)) {
            return [];
        }

        /** @var  $rawItem RawItem */
        foreach ($this->indexOfSameLayerRawItemsGroups[$startRawItemName] as $rawItem) {
            $parentName = '';

            if ($rewritableParentName !== null) {
                $parentName = $rewritableParentName;
            } else if ($rawItem->parent  === '') {
                $parentName = null;
            } else {
                $parentName = $rawItem->parent;
            }

            $formattedItem = new FormattedItem($rawItem->name, $parentName, $rawItem->type, []);
            $tree[] = $formattedItem;
        }

        foreach ($tree as &$treeItem) {
            /** @var  $tree FormattedItem[] */
            $itemSubtree = [];

            if ($this->indexOfAllRawItems[$treeItem->name]->relation !== '') {
                $itemSubtree = self::generateRecursive($this->indexOfAllRawItems[$treeItem->name]->relation, $treeItem->name);
            } else {
                $itemSubtree = self::generateRecursive($treeItem->name);
            }

            $treeItem->children = $itemSubtree;
        }

        return $tree;
    }
}
