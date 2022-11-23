<?php

namespace App\Tests\Api\Musement;

use App\Api\Musement\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpKernel\HttpCache\StoreInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ClientTest extends TestCase
{
    public function testSuccess(): void
    {

        $decoratedClient = new MockHttpClient();
        $store = $this->createMock(StoreInterface::class);

        $client = new Client($decoratedClient, $store, 'https://foo.bar');
        $response = $client->request('GET', 'somepath', [
            'query' => [
                'test' => 'abc',
            ],
        ]);

        $this->assertSame($response->getStatusCode(), 200);
    }
}
