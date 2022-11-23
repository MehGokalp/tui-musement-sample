<?php

namespace App\Api\WeatherApi\Endpoint\Forecast;

use App\Api\ApiException;
use App\Api\WeatherApi\Client;
use App\Api\WeatherApi\Endpoint\EndpointEnum;
use App\Api\WeatherApi\Endpoint\EndpointInterface;
use App\Api\WeatherApi\Endpoint\Forecast\Response\ForecastResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ForecastEndpoint implements EndpointInterface
{
    public function __construct(private readonly Client $client, private readonly ForecastResponseParser $forecastResponseParser)
    {
    }

    public function fetch(array $options): ForecastResponse
    {
        try {
            $response = $this->client->request(EndpointEnum::FORECAST->getMethod(), EndpointEnum::FORECAST->getPath(), $options);

            $statusCode = $response->getStatusCode();

            if (Response::HTTP_OK !== $statusCode) {
                throw new ApiException('bad response', null, $response);
            }

            $content = $response->getContent();
            $validator = new ForecastResponseValidator($content);
            $validator->validate();

            return $this->forecastResponseParser->parse($content);
        } catch (TransportExceptionInterface|HttpExceptionInterface|\JsonException $e) {
            throw new ApiException('error occurred', $e);
        }
    }
}
