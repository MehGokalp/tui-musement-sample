<?php

namespace App\Api\Musement;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

class Client implements HttpClientInterface
{
    public function __construct(private readonly HttpClientInterface $decoratedClient, private readonly string $baseUrl)
    {
    }

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $apiUrl = sprintf('%s/%s', $this->baseUrl, $url);

        // here we're decorating the base http client, we can add authentication or something else if needed
        return $this->decoratedClient->request($method, $apiUrl, $options);
    }

    public function stream($responses, float $timeout = null): ResponseStreamInterface
    {
        return $this->decoratedClient->stream($responses, $timeout);
    }
}
