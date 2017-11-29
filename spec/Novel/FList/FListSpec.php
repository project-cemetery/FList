<?php

namespace spec\Novel\FList;

use Novel\FList\Exception\FListShouldNotBeChanged;
use Novel\FList\Exception\HeadOfEmptyFList;
use Novel\FList\FList;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FListSpec extends ObjectBehavior
{
    function it_returns_array()
    {
        $array = [1, 2, 3, 4];

        $this->beConstructedWith(...$array);

        $this->toArray()->shouldReturn($array);
    }

    function it_has_head()
    {
        $array = [1, 2, 3, 4];

        $this->beConstructedWith(...$array);

        $this->head()->shouldReturn($array[0]);
    }

    function it_does_not_return_head_of_empty_list()
    {
        $this->beConstructedWith();

        $this
            ->shouldThrow(HeadOfEmptyFList::class)
            ->duringHead();
    }

    function it_able_to_be_empty()
    {
        $this->beConstructedWith();

        $this->isEmpty()
            ->shouldReturn(true);
    }

    function it_able_to_be_not_empty()
    {
        $this->beConstructedWith(1);

        $this->isEmpty()
            ->shouldReturn(false);
    }

    function it_has_tail()
    {
        $array = [1, 2, 3, 4];

        $this->beConstructedWith(...$array);

        $this->tail()->toArray()
            ->shouldReturn(array_slice($array, 1));
    }

    function it_has_find()
    {
        $array = [1, 2, 3, 4];

        $this->beConstructedWith(...$array);

        $findFunction = function ($v) {
            return $v === 3;
        };

        $this->find($findFunction)
            ->shouldReturn(3);
    }

    function it_is_filterable()
    {
        $array = [1, 2, 3, 4];

        $filerFunction = function ($v) {
            return $v < 3;
        };

        $this->beConstructedWith(...$array);

        $this
            ->filter($filerFunction)->toArray()
            ->shouldReturn(array_filter($array, $filerFunction));
    }

    function it_is_mapable()
    {
        $array = [1, 2, 3, 4];

        $mapFunction = function ($v) {
            return $v + 12;
        };

        $this->beConstructedWith(...$array);

        $this
            ->map($mapFunction)->toArray()
            ->shouldReturn(array_map($mapFunction, $array));
    }

    function it_is_iterable()
    {
        $array = [1, 2, 3, 4];

        $this->beConstructedWith(...$array);

        $this->shouldImplement(\Iterator::class);
    }

    function it_prohibits_mutation()
    {
        $array = [1, 2, 3, 4];

        $this->beConstructedWith(...$array);

        $this
            ->shouldThrow(FListShouldNotBeChanged::class)
            ->duringOffsetSet(1, 12);
    }

    function it_prohibits_unset()
    {
        $array = [1, 2, 3, 4];

        $this->beConstructedWith(...$array);

        $this
            ->shouldThrow(FListShouldNotBeChanged::class)
            ->duringOffsetUnset(1);
    }

    function it_is_prependable()
    {
        $array = [1, 2, 3];

        $this->beConstructedWith(...$array);

        $this->prepend(0)->toArray()
            ->shouldReturn([0, 1, 2, 3]);
    }
}
