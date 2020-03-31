<?php

namespace App;

use App\Seller;
use App\Category;
use App\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    const AVAILABLE = 'disponible';
    const NOT_AVAILABLE = 'no disponible';

    protected $fillable =[
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id',
    ];
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'pivot'
    ];


    public function available(){
        return $this->status == Product::AVAILABLE;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
