<?php

declare(strict_types=1);

namespace App\Models;

class ExchangeRate
{
    private float $exchangeRate;

    public function __construct(float $exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;
    }

    public function setExchangeRate(float $exchangeRate): void
    {
        $this->exchangeRate = $exchangeRate;
    }
    public function getExchangeRate(): float
    {
        return $this->exchangeRate;
    }
}