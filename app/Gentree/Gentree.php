<?php

namespace App\Gentree;

use App\Gentree\Dto\FormattedItem;
use App\Gentree\Dto\RawItem;
use App\Gentree\RawProviders\RawProviderInterface;
use function array_key_exists;

/**
 * Class for generating json tree from csv file
 */
class Gentree
{
    /**
     * @param $dataProvider RawProviderInterface
     *
     * @reture FormattedItem[]
     */
    public static function generateTree($dataProvider): array
    {
        $raw = $dataProvider->provideRaw();

        $indexOfAllRawItems = [];
        $indexOfSameLayerRawItemsGroups = [];
        $completedBranchesLinks = [];

        foreach ($raw as $rawItem) {
            $indexOfAllRawItems[$rawItem->name] = $rawItem;
            $indexOfSameLayerRawItemsGroups[$rawItem->parent][] = $rawItem;
        }

        return self::generateRecursive([
            'indexOfAllRawItems' => $indexOfAllRawItems,
            'indexOfSameLayerRawItemsGroups' => $indexOfSameLayerRawItemsGroups,
            'completedBranchesLinks' => $completedBranchesLinks
        ], '');
    }

    /**
     * @param $prerequisites array
     * @param $startRawItemName string
     * @param $rewritableParentName string|null
     *
     * @return Dto\FormattedItem[]
     */
    private static function generateRecursive(array $prerequisites, string $startRawItemName, string $rewritableParentName = null): array
    {
        /** @var $indexOfAllRawItems array<string, RawItem> */
        $indexOfAllRawItems = $prerequisites['indexOfAllRawItems'];
        /** @var $indexOfSameLayerRawItemsGroups array<string, RawItem> */
        $indexOfSameLayerRawItemsGroups = $prerequisites['indexOfSameLayerRawItemsGroups'];
        $completedBranchesLinks = $prerequisites['completedBranchesLinks'];

        /** @var  $tree FormattedItem[] */
        $tree = [];

        if (!array_key_exists($startRawItemName, $indexOfSameLayerRawItemsGroups)) {
            return [];
        }

        /** @var  $rawItem RawItem */
        foreach ($indexOfSameLayerRawItemsGroups[$startRawItemName] as $rawItem) {
            $parentName = '';

            if ($rewritableParentName !== null) {
                $parentName = $rewritableParentName;
            } else if ($rawItem->parent  === '') {
                $parentName = null;
            } else {
                $parentName = $rawItem->parent;
            }

            $formattedItem = new FormattedItem($rawItem->name, $parentName, []);
            $tree[] = $formattedItem;
        }

        foreach ($tree as &$treeItem) {
            /** @var  $tree FormattedItem[] */
            $itemSubtree = [];

            if ($indexOfAllRawItems[$treeItem->name]->relation !== '') {
                $itemSubtree = self::generateRecursive($prerequisites, $indexOfAllRawItems[$treeItem->name]->relation, $treeItem->name);
            } else {
                $itemSubtree = self::generateRecursive($prerequisites, $treeItem->name);
            }

            $treeItem->children = $itemSubtree;
        }

        return $tree;
    }
}
