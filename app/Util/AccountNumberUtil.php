<?php
/**
 * Created by Mofesola Banjo.
 * User: mb-pro-home
 * Date: 2020-01-23
 * Time: 23:15
 */

namespace App\Util;


use RandomLib\Factory as RandomGenerator;

class AccountNumberUtil
{
    public static function getRandomAccountNumber(): string
    {
        $randomGenerator = (new RandomGenerator())->getMediumStrengthGenerator();
        return sprintf(
            "%4d%3s",
            rand(1000, 9999),
            $randomGenerator->generateString(3, 'SAMTA')
        );
    }
}