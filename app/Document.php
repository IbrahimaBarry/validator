<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['name', 'source', 'sourceName', 'version', 'type', 'frequence', 'lang', 'last_reception'];

    public function receptions()
    {
    	return $this->hasMany(Reception::class);
    }
}
