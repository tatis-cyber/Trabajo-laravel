<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Users as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Users extends Authenticatable implements JWTSubject
{
    protected $table = 'usuarios';
    protected $primaryKey = 'cod_usuario';
    protected $fillable = ['nombre_usuario', 'nombre_completo', 'email', 'password', 'cod_rol'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = ['roles'];

    public function roles()
    {
        return $this->belongsTo(Rol::class, 'cod_rol', 'cod_rol');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}