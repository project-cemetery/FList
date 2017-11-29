<?php

namespace Novel\FList;


class FList
{
    private $elements;

    public function __construct(...$elements)
    {
        $this->elements = $elements;
    }

    public function filter(callable $callback) : FList
    {
        return new FList(
            ...array_filter($this->elements, $callback)
        );
    }

    public function map(callable $callback) : FList
    {
        return new FList(
            ...array_map($callback, $this->elements)
        );
    }

    public function toArray() : array
    {
        return $this->elements;
    }
}