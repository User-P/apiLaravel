<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     const USUARIO_VERIFICADO = '1';
     const USUARIO_NO_VERIFICADO = '0';

     const USUARIO_ADMINISTRADOR= 'true';
     const USUARIO_REGULAR= 'false';

     protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];

    public function setNameAttribute($value){
        $this -> attributes['name'] = strtolower($value);
    }

    public function setEmailAttribute($value){
        $this -> attributes['email'] = strtolower($value);
    }

    public function getNameAttribute($value){
        return ucwords($value);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function esVerificado(){
        return $this->verified == User::USUARIO_VERIFICADO;
    }

    public function esAdministrador(){
        return $this->admin == User::USUARIO_ADMINISTRADOR;
    }

    public static function generarVerificacionToken(){
        return Str::random(40);
    }
}
