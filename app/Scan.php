<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    protected $fillable = ['user_id', 'scanned', 'confirmed', 'admin'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function reception()
    {
    	return $this->belongsTo(Reception::class);
    }

    public function import()
    {
        return $this->hasOne(Import::class);
    }
}
