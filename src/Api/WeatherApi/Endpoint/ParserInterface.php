<?php

declare(strict_types=1);

namespace App\Api\WeatherApi\Endpoint;

interface ParserInterface
{
    public function parse(string $rawResponse);
}
