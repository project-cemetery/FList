<?php

namespace Novel\FList;


use Novel\FList\Exception\FListShouldNotBeChanged;

class FList implements \Iterator, \ArrayAccess
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

    // Iterator Interface

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

    // ArrayAccess Interface

    public function offsetExists($offset)
    {
        return isset($this->elements[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->elements[$offset]) ? $this->elements[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        throw new FListShouldNotBeChanged();
    }

    public function offsetUnset($offset)
    {
        throw new FListShouldNotBeChanged();
    }
}