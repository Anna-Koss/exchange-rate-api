<?php

namespace App\Controller;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use App\Repository\ExchangeRateRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ExchangeRateController extends AbstractController
{
    //private
    public CurrencyRepository $currencyRepository;
    private ExchangeRateRepository $exchangeRateRepository;

    public function __construct(ExchangeRateRepository $exchangeRateRepository, CurrencyRepository $currencyRepository)
    {
        // @Todo I can do interfaces for the Repositories
        $this->currencyRepository = $currencyRepository;
        $this->exchangeRateRepository = $exchangeRateRepository;
    }
    #[Route('/api/exchange-rate/{code}/{start}/{end}', name: 'app_exchange_rate', methods: ['GET'])]
    public function getExchangeRate(string $code, string $start, string $end): JsonResponse
    {
        // @TODO check required parameters

        //@Todo wrap up in try-catch
        $start = new DateTime($start);
        $end = new DateTime($end);

        /** @var Currency $currency */
        $currency = $this->currencyRepository
            ->findOneBy(['code' => $code]);

        // @Todo not an error but response
        if (!$currency) {
            return new JsonResponse(['error' => 'Currency not found'], 404);
        }

        $exchangeRates = $this->exchangeRateRepository
            ->findByCurrencyAndDateRange($currency, $start, $end);

        if (!$exchangeRates) {
            return new JsonResponse(['error' => 'Exchange rates not found'], 404);
        }

        $rates = [];
        foreach ($exchangeRates as $exchangeRate) {
            $rates[] = [
                'date' => $exchangeRate->getDateTime()->format('Y-m-d H:i:s'),
                'currency' => $currency->getName(),
                'rate' => $exchangeRate->getRate(),
            ];
        }
        return $this->json($rates);



    }
}
