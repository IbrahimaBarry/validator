<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    protected $fillable = ['user_id', 'exported', 'confirmed', 'admin'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function clipping()
    {
    	return $this->belongsTo(Clipping::class);
    }
}
