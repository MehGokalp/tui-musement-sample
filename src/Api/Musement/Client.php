<?php

declare(strict_types=1);

namespace App\Api\Musement;

use Symfony\Component\HttpClient\AsyncDecoratorTrait;
use Symfony\Component\HttpClient\CachingHttpClient;
use Symfony\Component\HttpKernel\HttpCache\StoreInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

class Client implements HttpClientInterface
{
    use AsyncDecoratorTrait;

    private readonly HttpClientInterface $decoratedClient;

    public function __construct(HttpClientInterface $decoratedClient, StoreInterface $store, private readonly string $baseUrl)
    {
        $this->decoratedClient = new CachingHttpClient($decoratedClient, $store);
    }

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $apiUrl = sprintf('%s/%s', $this->baseUrl, $url);

        // here we're decorating the base http client, we can add authentication or something else if needed
        return $this->decoratedClient->request($method, $apiUrl, $options);
    }

    /**
     * @codeCoverageIgnore
     */
    public function stream($responses, float $timeout = null): ResponseStreamInterface
    {
        return $this->decoratedClient->stream($responses, $timeout);
    }
}
