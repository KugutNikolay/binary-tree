<?php

namespace src;

/**
 * Class BinarySearchTree
 */
class BinarySearchTree
{
    /**
     * @var null|TreeNode
     */
    private ?TreeNode $root;

    /**
     * BinarySearchTree constructor.
     */
    public function __construct()
    {
        $this->root = null;
    }

    /**
     * @param $value
     */
    public function insert($value)
    {
        $node = new TreeNode($value);
        if (!$this->root) {
            $this->root = $node;
        } else {
            $this->insertNode($node, $this->root);
        }
    }

    /**
     * @param $node
     * @param $subtree
     */
    private function insertNode($node, &$subtree)
    {
        if (!$subtree) {
            $subtree = $node;
        } else {
            if ($node->value < $subtree->value) {
                $this->insertNode($node, $subtree->left);
            } else {
                $this->insertNode($node, $subtree->right);
            }
        }
    }

    /**
     * @param $value
     * @return null
     */
    public function search($value)
    {
        return $this->searchNode($value, $this->root);
    }

    /**
     * @param $value
     * @param $subtree
     * @param  int  $count
     * @return null
     */
    private function searchNode($value, $subtree, &$count = 0)
    {
        if (!$subtree) {
            return null;
        } else {
            $count++;
            if ($value == $subtree->value) {
                return $subtree;
            }

            if ($value < $subtree->value) {
                return $this->searchNode($value, $subtree->left, $count);
            } else {
                return $this->searchNode($value, $subtree->right, $count);
            }
        }
    }

    /**
     * @param  string  $indexField
     */
    public function saveIndexToFile(string $indexField): void
    {
        $index = $this->getDocumentsIndex();
        $fp = fopen(self::getFileName($indexField), 'w');
        fwrite($fp, json_encode($index));
        fclose($fp);
    }

    public static function getFileName(string $indexField): string
    {
        return 'index_' . str_replace('.','_', $indexField) . '.json';
    }

    public static function getIndexField(string $field): array
    {
        $indexFilename = self::getFileName($field);
        if (file_exists($indexFilename)) {
            return json_decode(file_get_contents($indexFilename), true);
        }
        return [];
    }

    /**
     * @return array
     */
    private function getDocumentsIndex(): array
    {
        $index = [];
        $this->traverseInorder($this->root, $index);
        return $index;
    }

    /**
     * @param $subtree
     * @param  array  $index
     */
    private function traverseInorder($subtree, array &$index): void
    {
        if ($subtree) {
            $this->traverseInorder($subtree->left, $index);
            foreach ($subtree->value->fields as $fieldName => $fieldValue) {
                if ($fieldValue !== null) {
                    if (!isset($index[$fieldName][$fieldValue])) {
                        $index[$fieldName][$fieldValue] = [];
                    }
                    $index[$fieldName][$fieldValue][] = $subtree->value->id;
                }
            }
            $this->traverseInorder($subtree->right, $index);
        }
    }
}