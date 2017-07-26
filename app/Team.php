<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name'];

    public function users()
    {
    	return $this->hasMany(User::class);
    }

    public function horaires() {
    	return $this->hasMany(Horaire::class);
    }
}
