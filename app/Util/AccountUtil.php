<?php
/**
 * Created by Mofesola Banjo.
 * User: mb-pro-home
 * Date: 2020-01-23
 * Time: 23:15
 */

namespace App\Util;


use App\Account;

class AccountUtil
{
    private static function getRandomAccountNumber(): string
    {
        return sprintf("%4d%3s", rand(1000, 9999), strtoupper(str_random(3)));
    }

    public static function generateAccountNumber(array $memo = []): string
    {
        $accountNumber = self::getRandomAccountNumber();
        if (
            array_key_exists($accountNumber, $memo) ||
            0 !== Account::where('account_number', '=', $accountNumber)->count()
        ) {
            $memo[$accountNumber] = 1;
            return self::generateAccountNumber($memo);
        } else {
            return $accountNumber;
        }
    }
}