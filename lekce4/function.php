<?php

const SEPARATOR = ';';
const CNB_EXCHANGE_RATES_URL = 'https://www.cnb.cz/cs/financni-trhy/devizovy-trh/kurzy-devizoveho-trhu/kurzy-devizoveho-trhu/denni_kurz.txt';

function processMessage(string $message): void
{
    $messageList = prepareOutput($message);
    processOutput($messageList);
}

function processOutput(array $messageList): void
{
    foreach ($messageList as $message) {
        echo $message."<br/>";
    }
}

function prepareOutput(string $message): array
{
    if (strpos($message, SEPARATOR)) {
        return getArrayFromStringBySeparator($message);
    }


    if ($message == 'kurzy') {
        return getExchangeRatesToArrayFromUrl();
    }

    return [$message];
}

function getExchangeRatesToArrayFromUrl(): array
{
    $kurzy = file_get_contents(CNB_EXCHANGE_RATES_URL);

    $output = explode(PHP_EOL, $kurzy);

    return $output;
}

function getArrayFromStringBySeparator(string $message): array
{
    $messageArray = explode(SEPARATOR, $message);

    return $messageArray;
}

function vdx(mixed $output): void
{
    var_dump($output);
    die;
}

