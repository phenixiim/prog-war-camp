<?php

class ExchangeRateStorageManager
{
    private IExchangeRatesStorageDatabaseAdapter $dbAdapter;

    public function __construct(IExchangeRatesStorageDatabaseAdapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function isStored(): bool
    {
        return $this->dbAdapter->isStored();
    }

    public function getExchangeRatesList(): ExchangeRateList
    {
        return $this->dbAdapter->getExchangeRatesList();
    }

    public function store(ExchangeRateList $exchangeRateList): bool
    {
        return $this->dbAdapter->saveExchangeRatesList($exchangeRateList);
    }
}