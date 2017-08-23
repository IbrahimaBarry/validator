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

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'permission_users');
    }

    public function receptions()
    {
        return $this->hasMany(Reception::class);
    }

    public function scans()
    {
        return $this->hasMany(Scan::class);
    }

    public function imports()
    {
        return $this->hasMany(Import::class);
    }

    public function clippings()
    {
        return $this->hasMany(Clipping::class);
    }

    public function exports()
    {
        return $this->hasMany(Export::class);
    }
}
