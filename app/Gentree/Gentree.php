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
     * @return FormattedItem[]
     */
    public function generateTree(RawProviderInterface $dataProvider): array
    {
        $raw = $dataProvider->provideRaw();

        foreach ($raw as $rawItem) {
            $this->indexOfAllRawItems[$rawItem->name] = $rawItem;
            $this->indexOfSameLayerRawItemsGroups[$rawItem->parent][] = $rawItem;
        }

        $tree = self::generateRecursive('');

        $this->clearParams();

        return $tree;
    }

    /**
     * @param $startRawItemName string
     * @param $rewritableParentName string|null need when subtree generating from relation property (in this case parent property must be rewritten)
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
                // highest layer of tree has "parent" property equals "" (empty string)
                // in formatted tree this value must be converted to "null"
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

    /**
     * @return void
     */
    private function clearParams() {
        $this->indexOfAllRawItems = [];
        $this->indexOfSameLayerRawItemsGroups = [];
    }
}
