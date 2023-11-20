<?php

namespace App\Repository;

use App\Entity\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CurrencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Currency::class);
    }

    public function getCurrencyCodes(): array
    {
        $currencies = [];
        foreach ($this->findAll() as $currencyRow) {
            $currencies[] = $currencyRow->getCode();
        }

        return $currencies;
    }
}