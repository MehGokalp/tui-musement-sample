<?php

namespace App\Api\Musement\Endpoint\City;

use App\Api\ApiException;
use App\Api\Musement\Client;
use App\Api\Musement\Endpoint\City\Response\CityResponse;
use App\Api\Musement\Endpoint\EndpointEnum;
use App\Api\Musement\Endpoint\EndpointInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CityEndpoint implements EndpointInterface
{
    public function __construct(private readonly Client $client, private readonly CityResponseParser $cityResponseParser)
    {
    }

    public function fetch(array $options): CityResponse
    {
        try {
            $response = $this->client->request(EndpointEnum::CITY->getMethod(), EndpointEnum::CITY->getPath(), $options);

            $statusCode = $response->getStatusCode();

            if (Response::HTTP_OK !== $statusCode) {
                throw new ApiException('bad response', null, $response);
            }

            $validator = new CityResponseValidator($response->getContent());
            $validator->validate();

            return $this->cityResponseParser->parse($response->getContent());
        } catch (TransportExceptionInterface|HttpExceptionInterface|\JsonException $e) {
            throw new ApiException('error occurred', $e);
        }
    }
}
