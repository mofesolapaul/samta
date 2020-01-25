<?php
/**
 * Created by Mofesola Banjo.
 * User: mb-pro-home
 * Date: 2020-01-24
 * Time: 17:50
 */

namespace App\Services;


use App\Account;
use App\Events\TransactionOccurred;
use App\Exceptions\TransferException;
use App\Transaction;
use App\Util\AccountNumberUtil;

class AccountService
{
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
     */
    public function performAccountToAccountTransfer(Account $sender, Account $receiver, float $amount): Account
    {
        if ($sender->account_number === $receiver->account_number) {
            throw new TransferException(__('accounts.impossible_transfer'));
        }

        $transaction = new Transaction();
        $transaction->sender_id = $sender->id;
        $transaction->receiver_id = $receiver->id;
        $transaction->amount = $amount;

        if ($sender->balance - $amount < 0) {
            $transaction->status = false;
        } else {
            $transaction->sender_balance = $sender->balance -= $amount;
            $transaction->receiver_balance = $receiver->balance += $amount;
            $sender->save();
            $receiver->save();
        }

        event(new TransactionOccurred($transaction));
        if (!$transaction->status) {
            throw new TransferException(__('accounts.insufficient_funds'));
        }
        return $sender;
    }
}