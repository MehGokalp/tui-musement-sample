<?php

declare(strict_types=1);

namespace App\Api\WeatherApi\Endpoint;

interface ValidatorInterface
{
    public function validate(): void;
}
