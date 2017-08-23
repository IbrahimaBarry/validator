<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['name', 'source', 'sourceName', 'location', 'version', 'type', 'frequence', 'lang', 'last_reception'];

    public function receptions()
    {
    	return $this->hasMany(Reception::class);
    }

    public function scans()
    {
    	return $this->hasMany(Scan::class);
    }

    public function imports()
    {
        return $this->hasMany(Import::class);
    }

    public function clippings()
    {
        return $this->hasMany(Clipping::class);
    }

    public function exports()
    {
        return $this->hasMany(Export::class);
    }
}
