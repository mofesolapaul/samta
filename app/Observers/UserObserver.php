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
        // create and credit account
        $account = $this->service->createNewAccount($user->id);
        $account->balance = 1000.00;
        $account->save();
    }
}