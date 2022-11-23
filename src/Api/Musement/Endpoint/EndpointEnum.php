<?php

namespace App\Api\Musement\Endpoint;

use Symfony\Component\HttpFoundation\Request;

enum EndpointEnum
{
    case CITY;

    public function getMethod(): string
    {
        return match ($this) {
            self::CITY => Request::METHOD_GET,
        };
    }

    public function getPath(): string
    {
        return match ($this) {
            self::CITY => 'cities.json',
        };
    }
}
