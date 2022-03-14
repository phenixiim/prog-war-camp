<?php

class ExchangeRatesParser
{
    const FIST_LINE = 0;
    const SECOND_LINE = 1;

    public static function parseTxt($exchangeRatesTxt): ExchangeRateList
    {
        $txtRows = explode(PHP_EOL, $exchangeRatesTxt);
        $exchangeRates = [];
        $date = null;
        foreach ($txtRows as $iterator => $row) {
            if ($iterator == self::FIST_LINE) {
                $date = $row;
                continue;
            }
            if ($iterator == self::SECOND_LINE) {
                // nothing to do, only headers
                continue;
            }
            $exchangeRateDataArray = explode('|', $row);
            if (empty($exchangeRateDataArray[0])) {
                continue;
            }
            $exchangeRate = new ExchangeRate();
            $exchangeRate->setCountry($exchangeRateDataArray[0]);
            $exchangeRate->setCurrency($exchangeRateDataArray[1]);
            $exchangeRate->setAmount((int)$exchangeRateDataArray[2]);
            $exchangeRate->setCode($exchangeRateDataArray[3]);
            $exchangeRate->setExchangeRateValue((float)str_replace(',', '.', $exchangeRateDataArray[4]));
            $exchangeRates[] = $exchangeRate;

        }

        return new ExchangeRateList(
            $date,
            $exchangeRates
        );
    }
}