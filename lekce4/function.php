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
        $messageArray = explode(SEPARATOR, $message);

        return $messageArray;
    } elseif ($message == 'kurzy') {
        $kurzy = file_get_contents(CNB_EXCHANGE_RATES_URL);

        return explode(PHP_EOL, $kurzy);
    } else { // REFACTOR: should be pure if/return
        return [$message];
    }
}

