<?php

require __DIR__ . '/src/BinarySearchTree.php';
require __DIR__ . '/src/Document.php';
require __DIR__ . '/src/DocumentCollection.php';
require __DIR__ . '/src/TreeNode.php';

use src\BinarySearchTree;
use src\Document;
use src\DocumentCollection;

$params = getopt("f:");
if (empty($params['f'])) {
    echo 'Field name required. Use option -f' . PHP_EOL;
} else {
    $field = $params['f'];

    $data = json_decode(file_get_contents('documents.json'), true);

    $collection = new DocumentCollection();
    $collection->addDocuments($data);

    // Creating an index and saving it to a file
    $index = new BinarySearchTree();
    $isInsertDocument = false;
    foreach ($collection->getDocuments() as $document) {
        if ($document->getField($field) !== null) {
            $index->insert(new Document($document->id, [$field => $document->getField($field)]));
            $isInsertDocument = true;
        }
    }

    if ($isInsertDocument) {
        $index->saveIndexToFile($field);
        echo 'Index created' . PHP_EOL;
    } else {
        echo 'Field not found' . PHP_EOL;
    }
}


