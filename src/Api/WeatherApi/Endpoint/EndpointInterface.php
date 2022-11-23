<?php

namespace App\Api\WeatherApi\Endpoint;

use App\Api\ApiException;

interface EndpointInterface
{
    /**
     * @throws ApiException
     */
    public function fetch(array $options): ResponseInterface;
}