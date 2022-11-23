<?php

namespace Api\Musement\Endpoint\City;

use App\Api\Musement\Endpoint\City\CityResponseValidator;
use PHPUnit\Framework\TestCase;

class CityResponseValidatorTest extends TestCase
{
    public function testValidateTrue(): void
    {
        $validator = new CityResponseValidator('[{"abc": "efg"}]');

        $validator->validate();
        $this->assertTrue(true);
    }

    public function testValidateFalse(): void
    {
        $validator = new CityResponseValidator('');

        $this->expectException(\JsonException::class);
        $validator->validate();
    }
}
