<?php
/**
 * Created by Mofesola Banjo.
 * User: mb-pro-home
 * Date: 2020-01-25
 * Time: 01:14
 */

use App\Account;

/**
 * @param string $accountNumber
 * @return string|string[]|null
 */
function format_account_number(string $accountNumber)
{
    return preg_replace('/([A-Z])/', '-$1', $accountNumber, 1);
}

/**
 * @param Account $account
 * @return string
 */
function format_account_balance(Account $account)
{
    return sprintf('%s%s', $account->currency->symbol, number_format($account->balance, 2));
}

function format_money($amount)
{
    return sprintf('€%s', number_format($amount, 2));
}

/**
 * @param string $targetCurrency
 * @param float $amount
 * @param array $rates
 * @return float
 */
function currency_conversion(string $targetCurrency, float $amount, array $rates)
{
    return round($amount * $rates[$targetCurrency], 2, PHP_ROUND_HALF_DOWN);
}

/**
 * @param float $value
 * @return float|int
 */
function inverse(float $value)
{
    return 1 / $value;
}

/**
 * @param Account $sender
 * @param Account $receiver
 * @return bool
 */
function are_currencies_different(Account $sender, Account $receiver)
{
    return $sender->currency->code !== $receiver->currency->code;
}
