<?php

namespace App\Http\Controllers\Product;

use App\User;
use App\Product;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Transformers\TransactionTransformer;

class ProductBuyerTransactionController extends ApiController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:' . TransactionTransformer::class)->only(['store']);
        $this->middleware('scope:purchase-product')->only(['store']);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, User $buyer)
    {
        $rules = [
            'quantity' => 'required|integer|min:1'
        ];
        $this->validate($request, $rules);

        if ($buyer->id == $product->seller_id) {
            return $this->errorResponse('1 El comprador debe ser diferente al vendedor', 409);
        }
        if (!$buyer->verified()) {
            return $this->errorResponse('2 El comprador no esta verificado', 409);
        }
        if (!$product->seller->verified()) {
            return $this->errorResponse('3 El vendedor debe ser un usuario verificado', 409);
        }

        if (!$product->available()) {
            return $this->errorResponse('4 El producto para esta transaccion no esta disponible', 409);
        }

        if ($product->quantity < $request->quantity) {
            return $this->errorResponse('5 El producto no tiene la cantidad disponible requeida para la transaccion', 409);
        }

        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id
            ]);
            return $this->showOne($transaction, 201);
        });
    }
}
