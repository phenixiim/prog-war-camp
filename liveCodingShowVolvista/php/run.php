<?php


const ORIGINAL_MD5_CAR_LIST_HASH = '020ded734626c3d77f7487d06ecb998e';
const URL = 'https://www.volvista.cz/ojete-vozy?carCheck2=BZR&fPrevodovka=&fNahon=59&fKm=&fFuel=&fNovinka=Y&fPobocka=&fYearFrom=1957&fYearTo=2022&fPriceFrom=150000&fPriceTo=2400000&fView=R&fSort=&fOnPage=20&fSortDesc=0&fSetOrder=&fSortDescMobile=&fSetOrderMobile=&fCount=20&fScroll=1&fLeasing=&fResetSearching=1&hlidaniLosem=&filtrace=1&page=ojete-vozy#anchor';
const LOG_PATH = '/var/log/volvista.check';
const MESSENGER_WEBHOOK_URL = 'https://hook.integromat.com/198owikj3y90e86xq9mnlxpu2tuno72p';


const FORMAT_CONTENT_LENGTH = 'Content-Length: %d';
const FORMAT_CONTENT_TYPE = 'Content-Type: %s';

const CONTENT_TYPE_JSON = 'application/json';
/**
 * @description Make a HTTP-POST JSON call
 *
 * @param string $url
 * @param array  $params
 *
 * @return bool|string HTTP-Response body or an empty string if the request fails or is empty
 */
function HTTPJSONPost(string $url, array $params)
{
    $content = json_encode($params);
    $response = file_get_contents(
        $url,
        false, // do not use_include_path
        stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => [ // header array does not need '\r\n'
                    sprintf(FORMAT_CONTENT_TYPE, CONTENT_TYPE_JSON),
                    sprintf(FORMAT_CONTENT_LENGTH, strlen($content)),
                ],
                'content' => $content,
            ],
        ])
    ); // no maxlength/offset
    if ($response === false) {
        return json_encode(['error' => 'Failed to get contents...']);
    }

    return $response;
}

function sendSlackMessage(string $message)
{
    echo('posilam...'.$message);
    $url = MESSENGER_WEBHOOK_URL;
    $data = array('text' => $message);
    HTTPJSONPost($url, $data);
}


$html = file_get_contents(URL);

preg_match('~<section.+vozy-vypis">(.*)</section>~s', $html, $matches);

$carsListHtml = $matches[1];
$carsCount = preg_match_all('~cars-item~', $carsListHtml);

$md5HashOfTheTargetPageCarsListHtml = md5($carsListHtml);

$result = 'no change';

if ($md5HashOfTheTargetPageCarsListHtml != ORIGINAL_MD5_CAR_LIST_HASH) {
    sendSlackMessage('POZOR! Změnila se stránka '.URL.', počet vozů: '.$carsCount.', novy hash je: '.$md5HashOfTheTargetPageCarsListHtml);
    $result = 'changed!';
    die;
}

sendSlackMessage('žádná změna, počet vozů: '.$carsCount);

$newLogLine = date('m / d / Y h:i:s a', time()).' - '.$result;
if (file_exists(LOG_PATH)) {
    file_put_contents(LOG_PATH, $newLogLine.PHP_EOL.file_get_contents(LOG_PATH));
}


