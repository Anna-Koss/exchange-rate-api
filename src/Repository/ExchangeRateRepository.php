<?php

namespace App\Repository;

use App\Entity\Currency;
use App\Entity\ExchangeRate;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ExchangeRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExchangeRate::class);
    }

    /**
     * @return ExchangeRate[]
     */
    public function findByCurrencyAndDateRange(Currency $currency, DateTime $start, DateTime $end): array
    {
        return $this->createQueryBuilder('er')
            ->andWhere('er.currency = :currency')
            ->andWhere('er.dateTime BETWEEN :start AND :end')
            ->setParameter('currency', $currency)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->orderBy('er.dateTime', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function save(ExchangeRate $exchangeRate): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($exchangeRate);
        $entityManager->flush();
    }
}