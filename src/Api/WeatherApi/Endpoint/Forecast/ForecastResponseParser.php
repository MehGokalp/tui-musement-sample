<?php

namespace App\Api\WeatherApi\Endpoint\Forecast;

use App\Api\Musement\Endpoint\ParserInterface;
use App\Api\WeatherApi\Endpoint\Forecast\Response\ForecastItem;
use App\Api\WeatherApi\Endpoint\Forecast\Response\ForecastResponse;

class ForecastResponseParser implements ParserInterface
{
    /**
     * @throws \JsonException
     */
    public function parse(string $rawResponse): ForecastResponse
    {
        $jsonResponse = json_decode($rawResponse, true, 512, JSON_THROW_ON_ERROR);

        /** @var []ForecastItem $parsedItems */
        $parsedItems = [];
        foreach ($jsonResponse['forecast']['forecastday'] as $item) {
            $parsedItem = new ForecastItem();

            $parsedItem->day = $item['date'];
            $parsedItem->condition = $item['day']['condition']['text'];

            $parsedItems[] = $parsedItem;
        }

        return new ForecastResponse($parsedItems);
    }
}
