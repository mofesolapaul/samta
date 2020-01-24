<?php
/**
 * Created by Mofesola Banjo.
 * User: mb-pro-home
 * Date: 2020-01-24
 * Time: 17:50
 */

namespace App\Services;


use App\Account;
use App\Util\AccountUtil;

class AccountService
{
    public function generateAccountNumber(array $memo = []): string
    {
        $accountNumber = AccountUtil::getRandomAccountNumber();
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
}