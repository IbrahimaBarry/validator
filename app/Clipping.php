<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clipping extends Model
{
    protected $fillable = ['user_id', 'clipped', 'confirmed', 'admin'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function import()
    {
    	return $this->belongsTo(Import::class);
    }

    public function export()
    {
        return $this->hasOne(Export::class);
    }
}
