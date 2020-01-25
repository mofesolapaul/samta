<?php
/**
 * Created by Mofesola Banjo.
 * User: mb-pro-home
 * Date: 2020-01-25
 * Time: 01:52
 */

namespace App\Repository;


use App\Currency;
use App\Transaction;

class CurrencyRepository
{
    /**
     * @return mixed
     */
    public function getAllCurrenciesInSimpleArray()
    {
        return Currency::all(['name','code','symbol'])
            ->reduce(function ($array, $item) {
                $array[$item->code] = "{$item->name}({$item->symbol})";
                return $array;
            }, []);
    }
}