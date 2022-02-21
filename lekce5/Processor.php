<?php

class Processor
{
    const SEPARATOR = ';';
    const CNB_EXCHANGE_RATES_URL = 'https://www.cnb.cz/cs/financni-trhy/devizovy-trh/kurzy-devizoveho-trhu/kurzy-devizoveho-trhu/denni_kurz.txt';

    private IDownloader $downloader;

    public function __construct(IDownloader $downloader)
    {
        $this->downloader = $downloader;
    }

    function processMessage(string $message): void
    {
        $messageList = $this->prepareOutput($message);
        $this->processOutput($messageList);
    }

    function processOutput(array $messageList): void
    {
        foreach ($messageList as $message) {
            echo $message."<br/>";
        }
    }

    function prepareOutput(string $message): array
    {
        if (strpos($message, $this::SEPARATOR)) {
            return $this->getArrayFromStringBySeparator($message);
        }

        if ($message == 'kurzy') {
            return $this->getExchangeRatesToArrayFromUrl();
        }

        return [$message];
    }

    function getExchangeRatesToArrayFromUrl(): array
    {
        $kurzyTxt = $this->downloader->download($this::CNB_EXCHANGE_RATES_URL);

        $exchangeRateList = ExchangeRatesParser::parseTxt($kurzyTxt);

        $output = [];

        /** @var ExchangeRate $exchangeRate */
        foreach ($exchangeRateList->getExchangeRates() as $exchangeRate) {
            $output[] = $exchangeRate->getCode().': '.$exchangeRate->getExchangeRateValue();
        }

        return $output;
    }

    function getArrayFromStringBySeparator(string $message): array
    {
        $messageArray = explode(SEPARATOR, $message);

        return $messageArray;
    }
}