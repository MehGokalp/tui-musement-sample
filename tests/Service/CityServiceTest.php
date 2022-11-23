<?php

namespace Service;

use App\Api\Musement\Endpoint\City\CityEndpoint;
use App\Api\Musement\Endpoint\City\Response\CityItem;
use App\Api\Musement\Endpoint\City\Response\CityResponse;
use App\Service\CityService;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class CityServiceTest extends TestCase
{
    public function testFetchEmptySuccess(): void
    {
        $cityEndpoint = $this->createMock(CityEndpoint::class);
        $logger = $this->createMock(LoggerInterface::class);

        $logger->expects($this->never())->method('critical');
        $cityEndpoint->expects($this->once())->method('fetch')->with([
            'query' => [
                'offset' => 0,
            ],
        ])->willReturn(new CityResponse([]));

        $cityService = new CityService($cityEndpoint, $logger);

        $iterator = $cityService->fetchAllCities();

        $this->assertCount(0, $iterator);
    }

    public function testFetchError(): void
    {
        $cityEndpoint = $this->createMock(CityEndpoint::class);
        $logger = $this->createMock(LoggerInterface::class);

        $dummyException = new \Exception();

        $logger->expects($this->once())->method('critical')->with($dummyException);
        $cityEndpoint->expects($this->once())->method('fetch')->with([
            'query' => [
                'offset' => 0,
            ],
        ])->willThrowException($dummyException);

        $cityService = new CityService($cityEndpoint, $logger);

        $iterator = $cityService->fetchAllCities();

        $this->assertCount(0, $iterator);
    }

    public function testSuccess(): void
    {
        $cityEndpoint = $this->createMock(CityEndpoint::class);
        $logger = $this->createMock(LoggerInterface::class);

        $logger->expects($this->never())->method('critical');

        $cityEndpoint->method('fetch')->willReturnOnConsecutiveCalls(
            new CityResponse([new CityItem()]),
            new CityResponse([])
        );

        $cityService = new CityService($cityEndpoint, $logger);

        $iterator = $cityService->fetchAllCities();

        $this->assertCount(1, $iterator);
    }

}
