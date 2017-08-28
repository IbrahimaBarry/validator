<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $fillable = ['user_id', 'imported', 'confirmed', 'affected', 'admin'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function scan()
    {
        return $this->belongsTo(Scan::class);
    }

    public function clipping()
    {
        return $this->hasOne(Clipping::class);
    }
}
