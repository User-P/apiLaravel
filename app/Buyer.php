<?php

namespace App;

use App\Transaction;
use App\Scoopes\BuyerScoope;
use App\Transformers\BuyerTransformer;

class Buyer extends User
{

    public $transformer = BuyerTransformer::class;

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
