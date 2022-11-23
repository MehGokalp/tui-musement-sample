<?php

declare(strict_types=1);

namespace App\Api\WeatherApi\Endpoint\Forecast\Response;

use App\Api\WeatherApi\Endpoint\ResponseInterface;

class ForecastResponse implements ResponseInterface
{
    public function __construct(public readonly array $items)
    {
    }
}
