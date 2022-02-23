<?php

const FORMAT_CONTENT_LENGTH = 'Content-Length: %d';
const FORMAT_CONTENT_TYPE = 'Content-Type: %s';

const CONTENT_TYPE_JSON = 'application/json';
/**
 * @description Make a HTTP-POST JSON call
 * @param string $url
 * @param array $params
 * @return bool|string HTTP-Response body or an empty string if the request fails or is empty
 */
function HTTPJSONPost(string $url, array $params)
{
    $content = json_encode($params);
    $response = file_get_contents($url, false, // do not use_include_path
        stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => [ // header array does not need '\r\n'
                    sprintf(FORMAT_CONTENT_TYPE, CONTENT_TYPE_JSON),
                    sprintf(FORMAT_CONTENT_LENGTH, strlen($content)),
                ],
                'content' => $content
            ]
        ])); // no maxlength/offset
    if ($response === false) {
        return json_encode(['error' => 'Failed to get contents...']);
    }

    return $response;
}

function sendSlackMessage(string $message)
{
    echo('posilam...'.$message);
    $url = 'https://hooks.slack.com/services/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';
    $data = array('text' => $message);
    HTTPJSONPost($url, $data);
}

const ORIGINAL_MD5_CAR_LIST_HASH = 'a9dd8a5ae3215158fb87c75a262397c4';
const URL = 'https://www.volvista.cz/vsechny-vozy?carCheck2=BZR&fPrevodovka=&fNahon=59&fNovinka=Y&fKm=&fFuel=&fPobocka=&fYearFrom=1957&fYearTo=2022&fPriceFrom=150000&fPriceTo=2400000&fView=R&fSort=&fOnPage=20&fSortDesc=0&fSetOrder=&fSortDescMobile=&fSetOrderMobile=&fCount=20&fScroll=1&fLeasing=&fResetSearching=1&hlidaniLosem=&filtrace=1&page=vsechny-vozy#anchor';

$html = file_get_contents(URL);

preg_match('~<section.+vozy-vypis">(.*)</section>~s', $html, $matches);

$md5HashOfTheTargetPageCarsListHtml = md5($matches[1]);

if ($md5HashOfTheTargetPageCarsListHtml != ORIGINAL_MD5_CAR_LIST_HASH) {
    sendSlackMessage('POZOR! Změnila se stránka '.URL.', novy hash je: '.$md5HashOfTheTargetPageCarsListHtml);
    die;
}

sendSlackMessage('Kontrola proběhla, nic nezměněno.');

