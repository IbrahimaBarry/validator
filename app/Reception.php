<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
	protected $fillable = [
        'sourceDate', 'nbrPage', 'date_scan', 'scanned', 'user_scan', 'date_import', 'imported', 'user_import', 
        'date_clipping', 'clipped', 'user_clippîng', 'date_export', 'exported', 'user_export', 'nbrArtTotal', 'time', 'message'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function document()
    {
    	return $this->belongsTo(Document::class);
    }
}
