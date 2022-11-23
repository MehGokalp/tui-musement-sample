<?php

namespace App\Api\Musement\Endpoint\City\Response;

use App\Api\Musement\Endpoint\ResponseInterface;

class CityResponse implements ResponseInterface, \IteratorAggregate, \Countable
{
    public function __construct(private readonly array $items)
    {
    }

    public function count(): int
    {
        return \count($this->items);
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->items);
    }
}
