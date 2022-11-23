<?php

declare(strict_types=1);

namespace App\Api\WeatherApi\Endpoint;

use Symfony\Component\HttpFoundation\Request;

enum EndpointEnum
{
    case FORECAST;

    public function getMethod(): string
    {
        return match ($this) {
            self::FORECAST => Request::METHOD_GET,
        };
    }

    public function getPath(): string
    {
        return match ($this) {
            self::FORECAST => 'forecast.json',
        };
    }
}
