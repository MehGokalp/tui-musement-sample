<?php

namespace App\Tests\Command;

use App\Api\Musement\Endpoint\City\Response\CityItem;
use App\Api\WeatherApi\Endpoint\Forecast\Response\ForecastItem;
use App\Api\WeatherApi\Endpoint\Forecast\Response\ForecastResponse;
use App\Command\ForecastCommand;
use App\Service\CityService;
use App\Service\ForecastService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ForecastCommandTest extends KernelTestCase
{
    public function testRunSuccess(): void
    {
        $cityService = $this->createMock(CityService::class);
        $cityItem = new CityItem();
        $cityItem->name = 'Amsterdam';
        $cityItem->latitude = '5555.555';
        $cityItem->longitude = '4444.4444';

        $cityService->expects($this->once())->method('fetchAllCities')->willReturn([
            $cityItem
        ]);

        $forecastService = $this->createMock(ForecastService::class);
        $forecastItem = new ForecastItem();
        $forecastItem->condition = 'Patchy rain possible';

        $forecastResponse = new ForecastResponse([
            $forecastItem,
            $forecastItem,
        ]);
        $forecastService->expects($this->once())->method('fetchForecast')->willReturn($forecastResponse);

        $logger = $this->createMock(LoggerInterface::class);
        $application = new Application();
        $application->add(new ForecastCommand($cityService, $forecastService, $logger));

        $commandTester = new CommandTester($application->find('app:forecast'));
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Proceed city Amsterdam | Patchy rain possible - Patchy rain possible', $output);
    }

    public function testRunFail(): void
    {
        $cityService = $this->createMock(CityService::class);
        $cityService->expects($this->once())->method('fetchAllCities')->willThrowException(new \Exception('test failure'));

        $forecastService = $this->createMock(ForecastService::class);

        $logger = $this->createMock(LoggerInterface::class);
        $application = new Application();
        $application->add(new ForecastCommand($cityService, $forecastService, $logger));

        $commandTester = new CommandTester($application->find('app:forecast'));
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('test failure', $output);
    }
}
