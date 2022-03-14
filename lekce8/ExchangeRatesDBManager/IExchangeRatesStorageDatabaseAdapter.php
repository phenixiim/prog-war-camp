<?php

interface IExchangeRatesStorageDatabaseAdapter
{
    public function isStored(): bool;

    public function getExchangeRatesList(): ExchangeRateList;

    public function saveExchangeRatesList(ExchangeRateList $exchangeRateList): bool;
}