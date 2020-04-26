<?php

namespace App;

use App\Product;
use App\Scoopes\SellerScoope;
use App\Transformers\SellerTransformer;

class Seller extends User
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope((new SellerScoope));
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public $transformer = SellerTransformer::class;
}
