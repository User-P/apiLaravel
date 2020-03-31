<?php

namespace App;

use App\Transaction;
use App\Scoopes\BuyerScoope;

class Buyer extends User
{

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope((new BuyerScoope));
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
