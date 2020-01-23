<?php
/**
 * Created by Mofesola Banjo.
 * User: mb-pro-home
 * Date: 2020-01-23
 * Time: 22:55
 */

namespace App\Observers;


use App\Account;
use App\Currency;
use App\User;
use App\Util\AccountUtil;
use DebugBar\DebugBar;

class UserObserver
{
    public function created(User $user)
    {
        // create account
        $account = new Account();
        $account->user_id = $user->id;
        $account->account_number = AccountUtil::generateAccountNumber();
        $account->currency_id = Currency::first()->id;
        $account->balance = 1000.00;
        $user->accounts()->save($account);
    }
}