<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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
    public function transform(User $user)
    {
        return [
            'identificador' => (int) $user->id,
            'nombre' => (string) $user->name,
            'correo' => (string) $user->email,
            'verificado' => (int) $user->verified,
            'administrador' => ($user->admin === 'true'),
            'fechaCreacion' => (string) $user->created_at,
            'fechaActualizacion' => (string) $user->update_at,
            'fechaEliminacion' => isset($user->delete_at) ? (string) $user->delete_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'hreef' => route('users.show', $user->id),
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
            'verificado' => 'verified',
            'administrador' => 'admin',
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
            'verified' => 'verificado',
            'admin' => 'administrador',
            'created_at' => 'fechaCreacion',
            'update_at' => 'fechaActualizacion',
            'delete_at' => 'fechaEliminacion',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
