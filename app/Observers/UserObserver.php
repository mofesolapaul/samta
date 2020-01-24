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
use App\Services\AccountService;
use App\User;

class UserObserver
{
    /**
     * @var AccountService
     */
    private $service;

    public function __construct(AccountService $service)
    {
        $this->service = $service;
    }

    public function created(User $user)
    {
        // create account
        $account = new Account();
        $account->user_id = $user->id;
        $account->account_number = $this->service->generateAccountNumber();
        $account->currency_id = Currency::first()->id;
        $account->balance = 1000.00;
        $user->accounts()->save($account);
    }
}