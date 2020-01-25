<?php
/**
 * Created by Mofesola Banjo.
 * User: mb-pro-home
 * Date: 2020-01-25
 * Time: 01:14
 */

use App\Account;
use App\Transaction;
use Carbon\Carbon;

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
    return format_money($account->balance, $account->currency->symbol);
}

/**
 * @param float $amount
 * @param string $currency
 * @return string
 */
function format_money(float $amount, string $currency)
{
    return sprintf('%s%s', $currency, number_format($amount, 2));
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

/**
 * @param Transaction $transaction
 * @param Account $accountInView
 * @return array
 */
function cherrypickRelevantTransactionDetails(Transaction $transaction, Account $accountInView)
{
    $itsMe = $transaction->sender->id === $accountInView->id;
    $value = $itsMe ? $transaction->sent_amount : $transaction->received_amount;
    $account = $itsMe ? $transaction->receiver->account_number : $transaction->sender->account_number;
    return [
        'date' => Carbon::parse($transaction->created_at)->format('j-m-Y H:i:s'),
        'originator' => $itsMe,
        'amount' => format_money($value, $accountInView->currency->symbol),
        'account' => format_account_number($account),
        'status' => $transaction->status ? 'Successful' : 'Failed'
    ];
}
