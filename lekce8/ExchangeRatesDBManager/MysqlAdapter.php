<?php

class MysqlAdapter implements IExchangeRatesStorageDatabaseAdapter
{
    private $pdo;

    public function __construct()
    {
        // Připojovací údaje
        define('SQL_HOST', 'some-mysql:3306');
        define('SQL_DBNAME', 'exchangeRates');
        define('SQL_USERNAME', 'root');
        define('SQL_PASSWORD', 'my-secret-pw');

        $dsn = 'mysql:dbname='.SQL_DBNAME.';host='.SQL_HOST.'';
        $user = SQL_USERNAME;
        $password = SQL_PASSWORD;

        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Connection failed: '.$e->getMessage());
        }
    }

    public function isStored(): bool
    {
        $sql = 'SELECT COUNT(*) from exchangeRates';
        $result = $this->pdo->prepare($sql);
        $result->execute();

        return (int)$result->fetchColumn() > 0;
    }

    public function getExchangeRatesList(): ExchangeRateList
    {
        $sql = 'SELECT * FROM exchangeRates';
        $result = $this->pdo->prepare($sql);
        $result->execute();
        $exchangeRates = $result->fetchAll();

        return $this->hydrateExchangeRatesList($exchangeRates);
    }

    public function saveExchangeRatesList(ExchangeRateList $exchangeRateList): bool
    {
        /** @var ExchangeRate $exchangeRate */
        foreach ($exchangeRateList->getExchangeRates() as $exchangeRate) {
            $sql = 'INSERT INTO exchangeRates (`country`, `currency`, `amount`, `code`, `exchangeRateValue`) VALUES (?,?,?,?,?)';
            $result = $this->pdo->prepare($sql);
            $country = $exchangeRate->getCountry();
            $currency = $exchangeRate->getCurrency();
            $amount = $exchangeRate->getAmount();
            $code = $exchangeRate->getCode();
            $exchangeRateValue = $exchangeRate->getExchangeRateValue();
            $result->bindParam(1, $country);
            $result->bindParam(2, $currency);
            $result->bindParam(3, $amount);
            $result->bindParam(4, $code);
            $result->bindParam(5, $exchangeRateValue);
            $result->execute();
        }

        if($this->isStored()) {
            return true;
        }

        throw new Exception('values NOT stored!');
    }

    private function hydrateExchangeRatesList(array $exchangeRates): ExchangeRateList
    {
        $exchangeRatesArray = [];
        foreach ($exchangeRates as $exchangeRateItem) {
            $exchangeRate = new ExchangeRate();
            $exchangeRate->setCode($exchangeRateItem['code']);
            $exchangeRate->setCountry($exchangeRateItem['country']);
            $exchangeRate->setCurrency($exchangeRateItem['currency']);
            $exchangeRate->setAmount($exchangeRateItem['amount']);
            $exchangeRate->setExchangeRateValue($exchangeRateItem['exchangeRateValue']);
            $exchangeRatesArray[] = $exchangeRate;
        }

        return new ExchangeRateList('n/a', $exchangeRatesArray);
    }
}