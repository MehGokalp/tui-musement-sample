<?php

namespace App\Api\Musement\Endpoint\City;

use App\Api\Musement\Endpoint\City\Response\CityItem;
use App\Api\Musement\Endpoint\City\Response\CityResponse;
use App\Api\Musement\Endpoint\ParserInterface;

class CityResponseParser implements ParserInterface
{
    /**
     * @throws \JsonException
     */
    public function parse(string $rawResponse): CityResponse
    {
        $jsonResponse = json_decode($rawResponse, true, 512, JSON_THROW_ON_ERROR);

        /** @var []CityItem $parsedItems */
        $parsedItems = [];
        foreach ($jsonResponse as $item) {
            $parsedItem = new CityItem();

            $parsedItem->id = $item['id'];
            $parsedItem->name = $item['name'];
            $parsedItem->latitude = $item['latitude'];
            $parsedItem->longitude = $item['longitude'];

            $parsedItems[] = $parsedItem;
        }

        return new CityResponse($parsedItems);
    }
}
