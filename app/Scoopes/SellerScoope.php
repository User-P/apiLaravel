<?php
namespace App\Scoopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class SellerScoope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->has('products');
    }
}
