<?php

namespace App\Api\WeatherApi\Endpoint;

interface ParserInterface
{
    public function parse(string $rawResponse);
}
