<?php

namespace App;

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
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function receptions()
    {
        return $this->hasMany(Reception::class);
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'permission_users');
    }

    public function horaires()
    {
        return $this->belongsToMany(Horaire::class);
    }
}
