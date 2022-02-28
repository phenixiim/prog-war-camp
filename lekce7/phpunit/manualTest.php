<?php

require('../../lekce5/ExchangeRates/ExchangeRatesParser.php');
require('../../lekce5/ExchangeRates/ExchangeRate.php');
require('../../lekce5/ExchangeRates/ExchangeRateList.php');

$exchangeRatesTxt = file_get_contents('./exchangeRates.txt');

$exchangeRatesList = ExchangeRatesParser::parseTxt($exchangeRatesTxt);

// test 1
/** @var ExchangeRate $firstExchangeRate */
$firstExchangeRate = $exchangeRatesList->getExchangeRates()[0];
echo('<pre>');
var_dump($firstExchangeRate);
echo('</pre>');

if($firstExchangeRate->getCode() == 'AUD') {
    echo('Ano, první excahnge rate je AUD');
}

// test 2
/** @var ExchangeRate $tenthExchangeRate */
$tenthExchangeRate = $exchangeRatesList->getExchangeRates()[9];
echo('<pre>');
var_dump($tenthExchangeRate);
echo('</pre>');

if($tenthExchangeRate->getCode() == 'INR' && $tenthExchangeRate->getExchangeRateValue() == '29,239') {
    echo('Ano, první excahnge rate je INR a má hodnotu 29,239');
}