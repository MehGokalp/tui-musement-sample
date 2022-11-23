<?php

namespace App\Api\WeatherApi\Endpoint\Forecast;

use App\Api\ApiException;
use App\Api\WeatherApi\Endpoint\ValidatorInterface;

class ForecastResponseValidator implements ValidatorInterface
{
    public function __construct(private readonly string $rawResponse)
    {
    }

    /**
     * @throws \JsonException
     */
    public function validate(): void
    {
        $jsonResponse = json_decode($this->rawResponse, true, 512, \JSON_THROW_ON_ERROR);

        if (!isset($jsonResponse['forecast']['forecastday'])) {
            throw new ApiException('invalid response');
        }
    }
}
