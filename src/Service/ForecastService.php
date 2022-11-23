<?php

namespace App\Service;

use App\Api\WeatherApi\Endpoint\Forecast\ForecastEndpoint;
use App\Api\WeatherApi\Endpoint\Forecast\Response\ForecastResponse;

class ForecastService
{
    public function __construct(private readonly ForecastEndpoint $forecastEndpoint)
    {
    }

    public function fetchForecast(string $lat, string $long, int $days): ForecastResponse
    {
        return $this->forecastEndpoint->fetch([
            'query' => [
                'q' => sprintf('%s,%s', $lat, $long),
                'days' => $days,
            ],
        ]);
    }
}
