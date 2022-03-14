<?php

class ExchangeRate
{
    private string $country;
    private string $currency;
    private int $amount;
    private string $code;
    private string $exchangeRateValue;

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getExchangeRateValue(): string
    {
        return strtr($this->exchangeRateValue,'.',',');
    }

    /**
     * @param string $exchangeRateValue
     */
    public function setExchangeRateValue(string $exchangeRateValue): void
    {
        $this->exchangeRateValue = $exchangeRateValue;
    }

}