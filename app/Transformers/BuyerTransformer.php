<?php

namespace App\Transformers;

use App\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
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
    public function transform(Buyer $buyer)
    {
        return [
            'identificador' => (int) $buyer->id,
            'nombre' => (string) $buyer->name,
            'correo' => (string) $buyer->email,
            'verified' => (int) $buyer->verified,
            'fechaCreacion' => (string) $buyer->created_at,
            'fechaActualizacion' => (string) $buyer->update_at,
            'fechaEliminacion' => isset($buyer->delete_at) ? (string) $buyer->delete_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'hreef' => route('buyers.show', $buyer->id),
                ],
                [
                    'rel' => 'buyer.categories',
                    'href' => route('buyers.categories.index', $buyer->id)
                ],
                [
                    'rel' => 'buyer.transactions',
                    'href' => route('buyers.transactions.index', $buyer->id)
                ],
                [
                    'rel' => 'buyer.sellers',
                    'href' => route('buyers.sellers.index', $buyer->id)
                ],
            ]
        ];
    }

    public static function originalAttribute($index)
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
