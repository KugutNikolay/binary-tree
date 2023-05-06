<?php

namespace src;

/**
 * Class TreeNode
 */
class TreeNode
{
    /**
     * @var mixed
     */
    public $value;
    /**
     * @var null
     */
    public $left;
    /**
     * @var null
     */
    public $right;

    /**
     * TreeNode constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
        $this->left = null;
        $this->right = null;
    }
}