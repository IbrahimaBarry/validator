<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    protected $fillable = ['user_id', 'document_id', 'reception_id', 'confirmed', 'admin'];

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
