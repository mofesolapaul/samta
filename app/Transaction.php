<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function sender()
    {
        return $this->hasOne(Account::class, null, 'sender_id');
    }

    public function receiver()
    {
        return $this->hasOne(Account::class, null, 'receiver_id');
    }
}
