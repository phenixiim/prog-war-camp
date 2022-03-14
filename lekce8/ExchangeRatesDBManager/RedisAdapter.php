<?php

class RedisAdapter implements IExchangeRatesStorageDatabaseAdapter
{
    const EXCHANGE_RATES_KEY = 'exchangeRatesList';
    private $predis;

    public function __construct()
    {
        $this->predis = new Predis\Client([
            'scheme' => 'tcp',
            'host' => 'some-redis',
            'port' => 6379,
        ]);
    }

    public function isStored(): bool
    {
        return $this->predis->exists(self::EXCHANGE_RATES_KEY);
    }

    public function getExchangeRatesList(): ExchangeRateList
    {
        $serializedExchangeRatesList = $this->predis->get(self::EXCHANGE_RATES_KEY);

        return unserialize($serializedExchangeRatesList);
    }

    public function saveExchangeRatesList(ExchangeRateList $exchangeRateList): bool
    {
        $serializedExchangeRatesList = serialize($exchangeRateList);

        $this->predis->set(self::EXCHANGE_RATES_KEY, $serializedExchangeRatesList);

        if($this->isStored()) {
            return true;
        }

        return false;
    }
}