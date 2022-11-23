<?php

namespace App\Service;

use App\Api\Musement\Endpoint\City\CityEndpoint;
use App\Api\Musement\Endpoint\City\Response\CityItem;
use Psr\Log\LoggerInterface;

class CityService
{
    private const OFFSET_STEP = 100;

    public function __construct(private readonly CityEndpoint $cityEndpoint, private readonly LoggerInterface $logger)
    {
    }

    /**
     * @return CityItem[]
     */
    public function fetchAllCities(): iterable
    {
        $cityIterator = new \AppendIterator();
        $offset = 0;

        while (true) {
            try {
                $response = $this->cityEndpoint->fetch([
                    'query' => [
                        'offset' => $offset,
                    ],
                ]);

                if (0 === \count($response)) {
                    break;
                }

                $cityIterator->append($response->getIterator());
                $offset += self::OFFSET_STEP;
            } catch (\Throwable $e) {
                $this->logger->critical($e);

                break;
            }
        }

        return $cityIterator;
    }
}
