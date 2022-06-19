<?php

use League\Csv\Reader;
use League\Csv\Statement;

require_once 'vendor/autoload.php';

$outputArray = [];
$sameLayerGroups = [];
$completedBranchesLinks = [];
$allRecords = [];

$csv = Reader::createFromPath('input.csv', 'r');
$csv->setDelimiter(';');
$csv->setHeaderOffset(0);
$records = iterator_to_array($csv->getRecords(['name', 'type', 'parent', 'relation']), false);

// create same layer groups

foreach ($records as $record) {
  $sameLayerGroups[$record['parent']][] = $record;
  $allRecords[$record['name']] = [
    'type' => $record['type'],
    'parent' => $record['parent'],
    'relation' => $record['relation'],
  ];
}

$tree = genTree('');
$jsonTree = json_encode($tree, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

$outputFile = fopen('/gentree/hostdir/output.json', 'w');
fwrite($outputFile, $jsonTree);

function genTree($startItemName, $replaceParentName = null)
{
  global $allRecords;
  global $sameLayerGroups;

  $tree = [];

  if (!array_key_exists($startItemName, $sameLayerGroups)) {
    return [];
  }

  foreach ($sameLayerGroups[$startItemName] as $item) {
    $parentName = '';

    if ($replaceParentName !== null) {
      $parentName = $replaceParentName;
    } else if ($item['parent']  === '') {
      $parentName = null;
    } else {
      $parentName = $item['parent'];
    }

    $formattedItem = getJsonItem($item['name'], $parentName);

    if (!empty($formattedItem)) {
      $tree[] = $formattedItem;
    }
  }

  foreach ($tree as &$treeItem) {
    $treeItemSubtree = [];

    if ($allRecords[$treeItem['itemName']]['relation'] !== '') {
      $treeItemSubtree = genTree($allRecords[$treeItem['itemName']]['relation'], $treeItem['itemName']);
    } else {
      $treeItemSubtree = genTree($treeItem['itemName']);
    }

    $treeItem['children'] = array_merge($treeItem['children'], $treeItemSubtree);
  }

  return $tree;
};

function getJsonItem($itemName, $parentName)
{
  return [
    'itemName' => $itemName,
    'parent' => $parentName,
    'children' => []
  ];
}
