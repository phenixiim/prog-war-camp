<?php

require('function.php');

require('Downloader/IDownloader.php');
require('Downloader/FileGetContentsDownloader.php');
require('Downloader/CurlDownloader.php');

require('ExchangeRates/ExchangeRatesParser.php');
require('ExchangeRates/ExchangeRate.php');
require('ExchangeRates/ExchangeRateList.php');

require('Processor.php');

if (isset($_GET['msg'])) {
    $messageFromGetParameterMsg = $_GET['msg'];

    $downloader = new FileGetContentsDownloader();
    //$downloader = new CurlDownloader();

    $processor = new Processor($downloader);

    $processor->processMessage($messageFromGetParameterMsg);
}