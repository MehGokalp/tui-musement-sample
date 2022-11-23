<?php

namespace Api\WeatherApi;

use App\Api\WeatherApi\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ClientTest extends TestCase
{
    public function testSuccess(): void
    {
        $decoratedClient = $this->createMock(HttpClientInterface::class);

        $decoratedClient->expects($this->once())->method('request')->with(
            'GET',
            'https://foo.bar/somepath',
            [
                'query' => [
                    'key' => 'somekey',
                    'test' => 'abc',
                ],
            ]
        );

        $client = new Client($decoratedClient, 'https://foo.bar', 'somekey');
        $client->request('GET', 'somepath', [
            'query' => [
                'test' => 'abc',
            ],
        ]);
    }
}
