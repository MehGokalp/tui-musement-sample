<?php

namespace App\Tests\Api\WeatherApi\Endpoint\Forecast;

use App\Api\ApiException;
use App\Api\WeatherApi\Endpoint\Forecast\ForecastResponseValidator;
use PHPUnit\Framework\TestCase;

class ForecastResponseValidatorTest extends TestCase
{
    public function testValidateTrue(): void
    {
        $validator = new ForecastResponseValidator('{"forecast":{"forecastday": []}}');

        $validator->validate();
        $this->assertTrue(true);
    }

    public function testValidateFalse(): void
    {
        $validator = new ForecastResponseValidator('');

        $this->expectException(\JsonException::class);
        $validator->validate();
    }

    public function testValidateFalseUnknownResponse(): void
    {
        $validator = new ForecastResponseValidator('{"forecast":{}}');

        $this->expectException(ApiException::class);
        $validator->validate();
    }
}
