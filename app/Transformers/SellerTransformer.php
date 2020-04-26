<?php

namespace App\Transformers;

use App\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Seller $seller)
    {
        return [
            'identificador' => (int) $seller->id,
            'nombre' => (string) $seller->name,
            'correo' => (string) $seller->email,
            'verified' => (int) $seller->verified,
            'fechaCreacion' => (string) $seller->created_at,
            'fechaActualizacion' => (string) $seller->update_at,
            'fechaEliminacion' => isset($seller->delete_at) ? (string) $seller->delete_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'hreef' => route('sellers.show', $seller->id),
                ],
                [
                    'rel' => 'seller.categories',
                    'href' => route('sellers.categories.index', $seller->id)
                ],
                [
                    'rel' => 'seller.transactions',
                    'href' => route('sellers.transactions.index', $seller->id)
                ],
                [
                    'rel' => 'seller.buyers',
                    'href' => route('sellers.buyers.index', $seller->id)
                ],
                [
                    'rel' => 'seller.products',
                    'href' => route('sellers.products.index', $seller->id)
                ],
            ]
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identificador' => 'id',
            'nombre' => 'name',
            'correo' => 'email',
            'verified' => 'verified',
            'fechaCreacion' => 'created_at',
            'fechaActualizacion' => 'update_at',
            'fechaEliminacion' => 'delete_at'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identificador',
            'name' => 'nombre',
            'email' => 'correo',
            'verified' => 'verified',
            'created_at' => 'fechaCreacion',
            'update_at' => 'fechaActualizacion',
            'delete_at' => 'fechaEliminacion',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
