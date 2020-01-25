<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $attributes = [
        'status' => true
    ];

    public function sender()
    {
        return $this->hasOne(Account::class, 'id', 'sender_id');
    }

    public function receiver()
    {
        return $this->hasOne(Account::class, 'id', 'receiver_id');
    }
}
