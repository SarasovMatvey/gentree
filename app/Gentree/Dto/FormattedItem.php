<?php

namespace App\Gentree\Dto;

class FormattedItem
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $parent;

    /**
     * @var string
     */
    public $type;

    /**
     * @var FormattedItem[]
     */
    public $children;

    /**
     * @param string $name
     * @param string $parent
     * @param FormattedItem[] $children
     */
    public function __construct(string $name, ?string $parent, string $type, array $children)
    {
        $this->name = $name;
        $this->parent = $parent;
        $this->children = $children;
    }
}