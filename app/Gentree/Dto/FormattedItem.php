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
     * @var FormattedItem[]
     */
    public $children;

    /**
     * @param string $name
     * @param string $parent
     * @param FormattedItem[] $children
     */
    public function __construct(string $name, ?string $parent, array $children)
    {
        $this->name = $name;
        $this->parent = $parent;
        $this->children = $children;
    }
}