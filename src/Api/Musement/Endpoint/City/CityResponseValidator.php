<?php

namespace App\Api\Musement\Endpoint\City;

use App\Api\ApiException;
use App\Api\Musement\Endpoint\ValidatorInterface;

class CityResponseValidator implements ValidatorInterface
{
    public function __construct(private readonly string $rawResponse)
    {
    }

    /**
     * @throws \JsonException|ApiException
     */
    public function validate(): void
    {
        $jsonResponse = json_decode($this->rawResponse, true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($jsonResponse)) {
            throw new ApiException('invalid response');
        }
    }
}
