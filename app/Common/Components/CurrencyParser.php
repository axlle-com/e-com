<?php

namespace App\Common\Components;

use App\Common\Models\Wallet\CurrencyExchangeRate;
use Exception;
use SimpleXMLElement;

class CurrencyParser
{
    private const URL = 'https://www.cbr-xml-daily.ru/daily_utf8.xml';//'http://www.cbr.ru/scripts/XML_daily.asp'
    private int $dateTo;
    private ?SimpleXMLElement $data = null;
    private array $errors = [];

    public function __construct(int $to = null)
    {
        $this->dateTo = $to ?? time();
    }

    private function setData(): void
    {
        $body = ['date_req' => date('d/m/Y', $this->dateTo)];
        try {
            $this->data = simplexml_load_string(file_get_contents(self::URL . '?' . http_build_query($body)));
        } catch (Exception $exception) {
            $this->setErrors(['exception' => $exception->getMessage()]);
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $error): self
    {
        foreach ($error as $key => $value) {
            if (is_array($value)) {
                foreach ($error as $key2 => $value2) {
                    $this->errors[$key2][] = $value2;
                }
            }
            $this->errors[$key][] = $value;
        }
        return $this;
    }

    private function getData(): SimpleXMLElement
    {
        if (empty($this->data)) {
            $this->setData();
        }
        return $this->data;
    }

    private function setCurrency(): int
    {
        return $this->getData() ? CurrencyExchangeRate::create($this->getData()) : 0;
    }

    public function setCurrencyPeriod(int $period): int
    {
        $cnt = 0;
        $date = strtotime(date('d.m.Y'));
        for ($i = 0; $i < $period; $i++) {
            $prevDate = $date - (60 * 60 * 24) * $i;
            $currency = new CurrencyParser($prevDate);
            $cnt += $currency->setCurrency();
        }
        return $cnt;
    }
}
