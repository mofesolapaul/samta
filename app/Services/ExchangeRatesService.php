<?php
/**
 * Created by Mofesola Banjo.
 * User: mb-pro-home
 * Date: 2020-01-25
 * Time: 08:13
 */

namespace App\Services;


use App\Exceptions\Currency\ExchangeRatesException;
use Cache;
use GuzzleHttp\Client;

class ExchangeRatesService
{
    /**
     * @var Client
     */
    private $http;

    /**
     * ExchangeRatesService constructor.
     * @param Client $http
     */
    public function __construct(Client $http)
    {
        $this->http = $http;
    }

    /**
     * @param string $baseCurrency
     * @param string $targetCurrency
     * @param float $amount
     * @return float
     * @throws ExchangeRatesException
     */
    public function convert(string $baseCurrency, string $targetCurrency, float $amount)
    {
        $pairId = $baseCurrency . $targetCurrency;
        if (Cache::has($pairId)) {
            $rates = Cache::get($pairId);
        } elseif (Cache::has($targetCurrency . $baseCurrency)) {
            $pairId = $targetCurrency . $baseCurrency;
            $rates = Cache::get($pairId);
            dump($rates);
        } else {
            $url = sprintf(config('constants.api_url'), $baseCurrency, $targetCurrency);
            $response = $this->http->get($url);
            if ($response->getStatusCode() !== 200) {
                throw new ExchangeRatesException(__('api.currency_exchange_failed',
                    ['base' => $baseCurrency, 'target' => $targetCurrency]));
            }
            $jsonData = json_decode($response->getBody());
            $knownValue = $jsonData->rates->$targetCurrency;
            $rates = [
                $baseCurrency => inverse($knownValue),
                $targetCurrency => $knownValue,
            ];
            Cache::put($pairId, $rates, 30);
        }
        return currency_conversion($targetCurrency, $amount, $rates);
    }
}