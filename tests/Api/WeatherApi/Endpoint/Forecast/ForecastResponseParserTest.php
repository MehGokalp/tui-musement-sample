<?php

namespace Api\WeatherApi\Endpoint\Forecast;

use App\Api\WeatherApi\Endpoint\Forecast\ForecastResponseParser;
use App\Api\WeatherApi\Endpoint\Forecast\Response\ForecastItem;
use PHPUnit\Framework\TestCase;

class ForecastResponseParserTest extends TestCase
{
    public function testParseSuccess(): void
    {
        $parser = new ForecastResponseParser();

        $response = $parser->parse('{"forecast":{"forecastday":[{"date":"2022-11-11","day":{"condition":{"text":"Normal"}}}]}}');

        $this->assertCount(1, $response->items);

        /** @var ForecastItem $forecastItem */
        $forecastItem = $response->items[0];
        $this->assertSame('2022-11-11', $forecastItem->day);
        $this->assertSame('Normal', $forecastItem->condition);
    }
}
