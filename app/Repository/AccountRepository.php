<?php
/**
 * Created by Mofesola Banjo.
 * User: mb-pro-home
 * Date: 2020-01-25
 * Time: 01:52
 */

namespace App\Repository;


use App\Transaction;

class AccountRepository
{
    public function getAllTransactions($account_id)
    {
        return Transaction::orWhere(['sender_id' => ':id', 'receiver_id' => ':id'])
            ->setBindings([$account_id, $account_id])
            ->paginate(5);
    }
}