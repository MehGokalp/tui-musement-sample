<?php

namespace Api\Musement;

use App\Api\Musement\Client;
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
                    'test' => 'abc',
                ],
            ]
        );

        $client = new Client($decoratedClient, 'https://foo.bar');
        $client->request('GET', 'somepath', [
            'query' => [
                'test' => 'abc',
            ],
        ]);
    }
}
