<?php

namespace App\Tests\Api\Musement\Endpoint\City;

use App\Api\ApiException;
use App\Api\Musement\Client;
use App\Api\Musement\Endpoint\City\CityEndpoint;
use App\Api\Musement\Endpoint\City\CityResponseParser;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Contracts\HttpClient\ResponseInterface;

class CityEndpointTest extends TestCase
{
    public function testThrowStatusCodeException(): void
    {
        $client = $this->createMock(Client::class);
        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())->method('getStatusCode')->willReturn(500);

        $client->expects($this->once())->method('request')->with('GET', 'cities.json', [])
            ->willReturn($response);

        $this->expectException(ApiException::class);
        $endpoint = new CityEndpoint($client, new CityResponseParser());
        $endpoint->fetch([]);
    }

    public function testThrowTransportException(): void
    {
        $client = $this->createMock(Client::class);

        $client->expects($this->once())->method('request')->with('GET', 'cities.json', [])
            ->willThrowException(new TransportException());

        $this->expectException(ApiException::class);
        $endpoint = new CityEndpoint($client, new CityResponseParser());
        $endpoint->fetch([]);
    }

    public function testSuccess(): void
    {
        $client = $this->createMock(Client::class);

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())->method('getStatusCode')->willReturn(200);
        $response->expects($this->once())->method('getContent')
            ->willReturn('[{"id":321,"name":"london","latitude":555.333,"longitude":123.321}]');

        $client->expects($this->once())->method('request')->with('GET', 'cities.json', [])
            ->willReturn($response);

        $endpoint = new CityEndpoint($client, new CityResponseParser());
        $parsed = $endpoint->fetch([]);

        $this->assertCount(1, $parsed);
    }
}
