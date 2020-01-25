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