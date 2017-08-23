<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clipping extends Model
{
    protected $fillable = ['user_id', 'document_id', 'confirmed', 'admin', 'reception_id'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function document()
    {
    	return $this->belongsTo(Document::class);
    }

    public function reception()
    {
        return $this->belongsTo(Reception::class);
    }
}
