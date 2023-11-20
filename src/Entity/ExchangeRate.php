<?php

namespace App\Entity;

use App\Repository\ExchangeRateRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExchangeRateRepository::class)]
#[ORM\Table(name: 'exchange_rate')]
class ExchangeRate
{
    #[ORM\Column(type: 'integer')]
    #[ORM\Id, ORM\GeneratedValue()]
    private int $id;

    #[ORM\ManyToOne(targetEntity: 'Currency')]
    #[ORM\JoinColumn(name: 'currency_id', referencedColumnName: 'id')]
    private Currency $currency;

    #[ORM\Column(type: 'datetime')]
    private DateTime $dateTime;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4)]
    private float $rate;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): ExchangeRate
    {
        $this->currency = $currency;

        return $this;
    }

    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }

    public function setDateTime(DateTime $dateTime): ExchangeRate
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): ExchangeRate
    {
        $this->rate = $rate;

        return $this;
    }
}