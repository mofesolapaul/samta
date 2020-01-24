<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
