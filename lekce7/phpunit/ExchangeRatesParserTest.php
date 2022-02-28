<?php
declare(strict_types=1);

require('../../lekce5/ExchangeRates/ExchangeRatesParser.php');
require('../../lekce5/ExchangeRates/ExchangeRate.php');
require('../../lekce5/ExchangeRates/ExchangeRateList.php');

use PHPUnit\Framework\TestCase;

final class ExchangeRatesParserTest extends TestCase
{
    private string $exchangeRatesTxt;

    public function testParseTxt()
    {
        $exchangeRatesList = ExchangeRatesParser::parseTxt($this->exchangeRatesTxt);

        /** @var ExchangeRate $exchangeRate */
        $exchangeRate = $exchangeRatesList->getExchangeRates()[0];

        $this->assertSame('ExchangeRate', get_class($exchangeRate));
        $this->assertSame('AUD', $exchangeRate->getCode());
        $this->assertSame('15,869', $exchangeRate->getExchangeRateValue());

        /** @var ExchangeRate $exchangeRate */
        $exchangeRate = $exchangeRatesList->getExchangeRates()[9];

        $this->assertSame('ExchangeRate', get_class($exchangeRate));
        $this->assertSame('INR', $exchangeRate->getCode());
        $this->assertSame('29,239', $exchangeRate->getExchangeRateValue());
        $this->assertSame(100, $exchangeRate->getAmount());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->exchangeRatesTxt = file_get_contents('./exchangeRates.txt');
    }
}