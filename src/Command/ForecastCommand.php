<?php

namespace App\Command;

use App\Service\CityService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:forecast',
    description: 'Add a short description for your command',
)]
class ForecastCommand extends Command
{
    public function __construct(private readonly CityService $cityService)
    {
        parent::__construct(null);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $count = 0;
        foreach ($this->cityService->fetchAllCities() as $city) {
            var_dump($city);
            $count++;
        }

        $io->success($count);

        return Command::SUCCESS;
    }
}
