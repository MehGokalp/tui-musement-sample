<?php

namespace App\Tests\Api\Musement\Endpoint\City;

use App\Api\ApiException;
use App\Api\Musement\Endpoint\City\CityResponseValidator;
use PHPUnit\Framework\TestCase;

class CityResponseValidatorTest extends TestCase
{
    public function testValidateTrue(): void
    {
        $validator = new CityResponseValidator('[{"id": "321"}]');

        $validator->validate();
        $this->assertTrue(true);
    }

    public function testValidateFalseJson(): void
    {
        $validator = new CityResponseValidator('sdfkjdslfds{][{');

        $this->expectException(\JsonException::class);
        $validator->validate();
    }

    public function testValidateFalse(): void
    {
        $validator = new CityResponseValidator('[{}]');

        $this->expectException(ApiException::class);
        $validator->validate();
    }
}
