<?php

namespace src;

/**
 * Class Document
 */
class Document
{

    /**
     * @var string
     */
    public string $id;
    /**
     * @var array
     */
    public array $fields;

    /**
     * Document constructor.
     * @param  string  $id
     * @param  array  $fields
     */
    public function __construct(string $id, array $fields)
    {
        $this->id = $id;
        $this->fields = $fields;
    }

    /**
     * @param $fieldName
     * @return mixed|null
     */
    public function getField($fieldName)
    {
        return $this->fields[$fieldName] ?? null;
    }
}
