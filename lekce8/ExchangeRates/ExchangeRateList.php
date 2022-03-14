<?php

class ExchangeRateList
{
    private string $date;
    private array $exchangeRates;

    public function __construct(string $date, array $exchangeRates)
    {
        $this->date = $date;
        foreach ($exchangeRates as $exchangeRate) {
            if (!$exchangeRate instanceof ExchangeRate) {
                throw new Exception('Inserted member od ExchangeRateList is not ExchangeRate object!');
            }
        }
        $this->exchangeRates = $exchangeRates;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return array
     */
    public function getExchangeRates(): array
    {
        return $this->exchangeRates;
    }
}