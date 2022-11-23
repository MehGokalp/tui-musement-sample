<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\CityService;
use App\Service\ForecastService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:forecast',
    description: 'Add a short description for your command',
)]
class ForecastCommand extends Command
{
    private const DEFAULT_FETCH_DATE = 2;

    public function __construct(
        private readonly CityService     $cityService,
        private readonly ForecastService $forecastService,
        private readonly LoggerInterface $logger
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            foreach ($this->cityService->fetchAllCities() as $city) {
                $forecastResponse = $this->forecastService->fetchForecast($city->latitude, $city->longitude, self::DEFAULT_FETCH_DATE);

                $io->success(sprintf('Proceed city %s | %s - %s', $city->name, $forecastResponse->items[0]->condition, $forecastResponse->items[1]->condition));
            }
        } catch (\Throwable $e) {
            $this->logger->critical($e);
            $io->error(sprintf('Something happened: %s', $e->getMessage()));
        }

        return Command::SUCCESS;
    }
}
