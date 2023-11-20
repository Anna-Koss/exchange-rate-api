<?php

namespace App\Command;

use App\Entity\Currency;
use App\Entity\ExchangeRate;
use App\Repository\ExchangeRateRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Repository\CurrencyRepository;

#[AsCommand(name: 'app:get-actual-rates')]
class GetActualRatesCommand extends Command
{
    private const API_RATES_URL = 'https://blockchain.info/ticker';

    private HttpClientInterface $client;

    private CurrencyRepository $currencyRepository;

    private ExchangeRateRepository $exchangeRateRepository;

    public function __construct(HttpClientInterface $client, CurrencyRepository $currencyRepository, ExchangeRateRepository $exchangeRateRepository)
    {
        $this->client = $client;
        $this->currencyRepository = $currencyRepository;
        $this->exchangeRateRepository = $exchangeRateRepository;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $datetime = new \DateTime();
        $content = $this->getRatesFromApi(); // array from API, all the currencies

        foreach ($this->currencyRepository->findAll() as $currency) {
            $newRate = new ExchangeRate();
            /** @var Currency $currency */
            $currencyCode = $currency->getCode();
            $newRate->setCurrency($currency)->setDateTime($datetime)->setRate((float) $content[$currencyCode]['last']);
            $this->exchangeRateRepository->save($newRate);
        }

        return Command::SUCCESS;
        // or return Command::FAILURE or return Command::INVALID depends on Try-Catch
    }

    private function getRatesFromApi(): array
    {
        $response = $this->client->request(
            'GET',
            self::API_RATES_URL
        );
        // @Todo $statusCode = 200 and Try-Catch  -- notify about error while getting currencies from API
        $statusCode = $response->getStatusCode();

        return $response->toArray();
    }
}