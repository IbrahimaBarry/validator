<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = ['type', 'description', 'user_id'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
