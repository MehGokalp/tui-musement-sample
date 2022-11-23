<?php

namespace App\Tests\Api\Musement\Endpoint\City;

use App\Api\Musement\Endpoint\City\CityResponseParser;
use App\Api\Musement\Endpoint\City\Response\CityItem;
use PHPUnit\Framework\TestCase;

class CityResponseParserTest extends TestCase
{
    public function testParseSuccess(): void
    {
        $parser = new CityResponseParser();

        $response = $parser->parse('[{"id":321,"name":"london","latitude":555.333,"longitude":123.321}]');

        $this->assertCount(1, $response);

        /** @var CityItem $cityItem */
        $cityItem = $response->getIterator()->current();
        $this->assertSame(321, $cityItem->id);
        $this->assertSame('london', $cityItem->name);
        $this->assertSame('555.333', $cityItem->latitude);
        $this->assertSame('123.321', $cityItem->longitude);
    }
}
