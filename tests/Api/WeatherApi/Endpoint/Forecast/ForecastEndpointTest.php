<?php

namespace App\Tests\Api\WeatherApi\Endpoint\Forecast;

use App\Api\ApiException;
use App\Api\WeatherApi\Client;
use App\Api\WeatherApi\Endpoint\Forecast\ForecastEndpoint;
use App\Api\WeatherApi\Endpoint\Forecast\ForecastResponseParser;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ForecastEndpointTest extends TestCase
{
    public function testThrowStatusCodeException(): void
    {
        $client = $this->createMock(Client::class);
        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())->method('getStatusCode')->willReturn(500);

        $client->expects($this->once())->method('request')->with('GET', 'forecast.json', [])
            ->willReturn($response);

        $this->expectException(ApiException::class);
        $endpoint = new ForecastEndpoint($client, new ForecastResponseParser());
        $endpoint->fetch([]);
    }

    public function testThrowTransportException(): void
    {
        $client = $this->createMock(Client::class);

        $client->expects($this->once())->method('request')->with('GET', 'forecast.json', [])
            ->willThrowException(new TransportException());

        $this->expectException(ApiException::class);
        $endpoint = new ForecastEndpoint($client, new ForecastResponseParser());
        $endpoint->fetch([]);
    }

    public function testSuccess(): void
    {
        $client = $this->createMock(Client::class);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())->method('getStatusCode')->willReturn(200);
        $response->expects($this->once())->method('getContent')
            ->willReturn('{"forecast":{"forecastday":[{"date":"2022-11-11","day":{"condition":{"text":"Normal"}}}]}}');

        $client->expects($this->once())->method('request')->with('GET', 'forecast.json', [])
            ->willReturn($response);

        $endpoint = new ForecastEndpoint($client, new ForecastResponseParser());
        $parsed = $endpoint->fetch([]);

        $this->assertCount(1, $parsed->items);
    }
}
