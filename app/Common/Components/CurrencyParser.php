<?php

namespace App\Common\Components;

use Exception;
use SimpleXMLElement;
use App\Common\Models\Errors\Errors;
use App\Common\Models\Wallet\CurrencyExchangeRate;

class CurrencyParser
{
    use Errors;

    private const URL = 'http://www.cbr.ru/scripts/XML_daily.asp';
    private const URL_SECOND = 'https://www.cbr-xml-daily.ru/daily_utf8.xml';
    private int $dateTo;
    private ?SimpleXMLElement $data = null;

    public function __construct(int $to = null)
    {
        $this->dateTo = $to ?? time();
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

    private function setCurrency(): int
    {
        return $this->getData() ? CurrencyExchangeRate::create($this->getData()) : 0;
    }

    private function getData(): SimpleXMLElement
    {
        if (empty($this->data)) {
            $this->setData();
        }
        return $this->data;
    }

    private function setData(): void
    {
        $body = ['date_req' => date('d/m/Y', $this->dateTo)];
        try {
            $this->data = simplexml_load_string(file_get_contents(self::URL . '?' . http_build_query($body)));
        } catch (Exception $exception) {
//            $this->setErrors(_Errors::exception($exception, $this));
        }
    }
}
