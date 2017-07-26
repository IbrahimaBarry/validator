<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horaire extends Model
{
    protected $fillable = ['day', 'start', 'end'];

    public function team()
    {
    	return $this->belongsTo(Team::class);
    }

    public function users() {
    	return $this->belongsToMany(User::class);
    }
}
