<?php

namespace App\Gentree\Dto;

class RawItem
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $parent;

    /**
     * @var string
     */
    public $relation;

    /**
     * @param string $name
     * @param string $type
     * @param string $parent
     * @param string $relation
     */
    public function __construct(string $name, string $type, string $parent, string $relation)
    {
        $this->name = $name;
        $this->type = $type;
        $this->parent = $parent;
        $this->relation = $relation;
    }
}