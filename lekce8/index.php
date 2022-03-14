<?php

require('function.php');

require('Downloader/IDownloader.php');
require('Downloader/FileGetContentsDownloader.php');
require('Downloader/CurlDownloader.php');
require('Downloader/NewUltraFastSpeedPHPDownloader.php');

require('ExchangeRates/ExchangeRatesParser.php');
require('ExchangeRates/ExchangeRate.php');
require('ExchangeRates/ExchangeRateList.php');

require('ExchangeRatesDBManager/ExchangeRateStorageManager.php');
require('ExchangeRatesDBManager/IExchangeRatesStorageDatabaseAdapter.php');
require('ExchangeRatesDBManager/RedisAdapter.php');
require('ExchangeRatesDBManager/MysqlAdapter.php');

require('vendor/autoload.php');

require('Processor.php');

if (isset($_GET['msg'])) {
    $messageFromGetParameterMsg = $_GET['msg'];

    //$downloader = new FileGetContentsDownloader();
    //$downloader = new NewUltraFastSpeedPHPDownloader();
    $downloader = new CurlDownloader();

    $dbAdapter = new MysqlAdapter();
    //$dbAdapter = new RedisAdapter();

    $storageManager = new ExchangeRateStorageManager($dbAdapter);

    $processor = new Processor($downloader, $storageManager);

    $processor->processMessage($messageFromGetParameterMsg);
}