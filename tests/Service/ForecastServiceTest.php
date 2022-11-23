<?php

namespace Service;

use App\Api\WeatherApi\Endpoint\Forecast\ForecastEndpoint;
use App\Api\WeatherApi\Endpoint\Forecast\Response\ForecastResponse;
use App\Service\ForecastService;
use PHPUnit\Framework\TestCase;

class ForecastServiceTest extends TestCase
{
    public function testSuccess(): void
    {
        $endpoint = $this->createMock(ForecastEndpoint::class);

        $endpoint->expects($this->once())->method('fetch')->with([
            'query' => [
                'q' => '3.5,1.2',
                'days' => 2,
            ],
        ])->willReturn(new ForecastResponse([]));

        $service = new ForecastService($endpoint);

        $service->fetchForecast('3.5', '1.2', 2);
    }
}
