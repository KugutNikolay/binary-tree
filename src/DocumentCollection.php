<?php

namespace src;

/**
 * Class DocumentCollection
 */
class DocumentCollection
{

    /**
     * @var array|null
     */
    private ?array $documents = null;

    /**
     * @return array
     */
    public function getDocuments(): array
    {
        return $this->documents;
    }

    /**
     * @param  array  $documents
     */
    public function addDocuments(array $documents): void
    {
        foreach ($documents as $document) {
            $fields = [];
            $this->getDocumentFields($document, $fields, null);
            $this->addDocument(new Document($document['id'], $fields));
        }
    }

    /**
     * @param  Document  $document
     */
    public function addDocument(Document $document)
    {
        $this->documents[$document->id] = $document;
    }

    /**
     * @param  string  $fieldName
     * @param  mixed  $fieldValue
     * @return array
     */
    public function searchWithoutIndex(string $fieldName, $fieldValue)
    {
        $result = [];
        $count = 0;
        foreach ($this->documents as $document) {
            if ($document->getField($fieldName) == $fieldValue) {
                $result[] = $document;
            }
            $count++;
        }
        return ['result' => $result, 'count' => $count];
    }

    /**
     * @param  string  $fieldName
     * @param  mixed  $fieldValue
     * @return array
     */
    public function searchWithIndex(string $fieldName, $fieldValue): array
    {
        $index = BinarySearchTree::getIndexField($fieldName);
        $result = [];
        $count = 0;
        if (isset($index[$fieldName][$fieldValue])) {
            foreach ($index[$fieldName][$fieldValue] as $documentId) {
                $document = $this->getDocumentById($documentId);
                if ($document) {
                    $result[] = $document;
                }
                $count++;
            }
        }
        return ['result' => $result, 'count' => $count];
    }

    /**
     * @param $id
     * @return Document|null
     */
    private function getDocumentById($id): ?Document
    {
        return $this->documents[$id] ?? null;
    }

    /**
     * @param  array  $items
     * @param  array  $fields
     * @param  string|null  $parentKey
     */
    private function getDocumentFields(array $items, array &$fields, ?string $parentKey): void
    {
        foreach ($items as $key => $value) {
            $index = $parentKey ? $parentKey . '.' . $key : $key;
            if (is_array($value)) {
                $this->getDocumentFields($value, $fields, $index);
            } else {
                $fields[$index] = $value;
            }
        }
    }
}
