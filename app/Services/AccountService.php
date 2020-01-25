<?php
/**
 * Created by Mofesola Banjo.
 * User: mb-pro-home
 * Date: 2020-01-24
 * Time: 17:50
 */

namespace App\Services;


use App\Account;
use App\Currency;
use App\Events\TransactionOccurred;
use App\Exceptions\Currency\ExchangeRatesException;
use App\Exceptions\TransferException;
use App\Transaction;
use App\Util\AccountNumberUtil;

class AccountService
{
    /**
     * @var ExchangeRatesService
     */
    private $ratesService;

    public function __construct(ExchangeRatesService $ratesService)
    {
        $this->ratesService = $ratesService;
    }

    public function generateAccountNumber(array $memo = []): string
    {
        $accountNumber = AccountNumberUtil::getRandomAccountNumber();
        if (
            array_key_exists($accountNumber, $memo) ||
            0 !== Account::where('account_number', '=', $accountNumber)->count()
        ) {
            $memo[$accountNumber] = 1;
            return $this->generateAccountNumber($memo);
        } else {
            return $accountNumber;
        }
    }

    /**
     * @param Account $sender
     * @param Account $receiver
     * @param float $amount
     * @return Account
     * @throws TransferException
     * @throws ExchangeRatesException
     */
    public function performAccountToAccountTransfer(Account $sender, Account $receiver, float $amount): Account
    {
        if ($sender->account_number === $receiver->account_number) {
            throw new TransferException(__('accounts.impossible_transfer'));
        }

        $transaction = new Transaction();
        $transaction->sender_id = $sender->id;
        $transaction->receiver_id = $receiver->id;
        $transaction->sent_amount = $amount;

        if ($sender->balance - $amount >= 0) {
            $transaction->received_amount = are_currencies_different($sender, $receiver)
                ? $this->ratesService->convert($sender->currency->code, $receiver->currency->code, $amount)
                : $amount;
            $transaction->sender_balance = $sender->balance -= $amount;
            $transaction->receiver_balance = $receiver->balance += $transaction->received_amount;
            $sender->save();
            $receiver->save();
            $transaction->status = true;
        }

        event(new TransactionOccurred($transaction));
        if (!$transaction->status) {
            throw new TransferException(__('accounts.insufficient_funds'));
        }
        return $sender;
    }

    /**
     * @param $user_id
     * @param string|null $currency
     * @return Account
     */
    public function createNewAccount($user_id, $currency = null): Account
    {
        $account = new Account();
        $account->user_id = $user_id;
        $account->account_number = $this->generateAccountNumber();
        $account->currency_id = $currency ? Currency::where([
            'code' => $currency
        ])->first()->id : Currency::first()->id;
        $account->save();
        return $account;
    }
}