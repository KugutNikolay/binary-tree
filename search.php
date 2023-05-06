<?php

require __DIR__ . '/src/BinarySearchTree.php';
require __DIR__ . '/src/Document.php';
require __DIR__ . '/src/DocumentCollection.php';
require __DIR__ . '/src/TreeNode.php';

use src\DocumentCollection;

$params = getopt("f:v:");
if (empty($params['f'])) {
    echo 'Field name required. Use option -f' . PHP_EOL;
} else {
    $field = $params['f'];
    $value = $params['v'] ?? '';

    $data = json_decode(file_get_contents('documents.json'), true);

    $collection = new DocumentCollection();
    $collection->addDocuments($data);

    // Search without using index

    echo PHP_EOL . "---------------- Search results without using index: -------------------" . PHP_EOL;

    $searchResult = $collection->searchWithoutIndex($field, $value);
    foreach ($searchResult['result'] as $document) {
        echo "- Document ID #" . $document->id . PHP_EOL;
    }
    echo "Number of comparison operations: " . $searchResult['count'] . PHP_EOL;


    // Search using index

    echo PHP_EOL . "---------------- Search results using index: -------------------" . PHP_EOL;

    $searchResult = $collection->searchWithIndex($field, $value);
    foreach ($searchResult['result'] as $document) {
        echo "- Document ID #" . $document->id . PHP_EOL;
    }
    echo "Number of comparison operations: " . $searchResult['count'] . PHP_EOL . PHP_EOL;
}