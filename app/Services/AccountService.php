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
        $transaction = new Transaction();
        $transaction->sender()->setModel($sender);
        $transaction->sender()->setModel($receiver);

        if ($sender->balance - $amount < 0) {
            $transaction->status = false;
        } else {
            $sender->balance -= $amount;
            $receiver->balance += $amount;
            $sender->save();
            $receiver->save();
        }

        event(new TransactionOccurred($transaction));
        if (!$transaction->status) {
            throw new TransferException(__('insufficient_funds'));
        }
        return $sender;
    }
}