<?php

namespace Novel\FList;


class FList implements \Iterator
{
    private $elements;

    private $position;

    public function __construct(...$elements)
    {
        $this->elements = $elements;

        $this->position = 0;
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

    public function current()
    {
        return $this->elements[$this->position];
    }

    public function next()
    {
        $this->position = $this->position + 1;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return $this->position < count($this->elements);
    }

    public function rewind()
    {
        $this->position = 0;
    }
}
