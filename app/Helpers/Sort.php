<?php

namespace App\Helpers;

use App\Reception;

/**
* Class for sorting Receptions
*/
class Sort
{	
	public function __construct()
	{

	}

	/**
     * Display a listing of the resource sort.
     *
     * @param. string  $model
     * @param. \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function index($model, $request)
	{
		$conditions = [];

		if ($request->search != '')
			$conditions['name'] = $request->search;
		if ($request->type != 'Type')
			$conditions['type'] = $request->type;
		if ($request->lang != 'Langue')
			$conditions['lang'] = $request->lang;
		if ($request->version != 'Version')
			$conditions['version'] = $request->version;

		// RECEPTION
		if ($model == 'reception') {
			if ($request->date != '') {
	            return Reception::with(['user', 'document'])
	                ->whereHas('document', function($query) use ($conditions) {
	                    foreach ($conditions as $key => $value) {
	                    	if ($key == 'name')
	                    		$query->where($key, 'LIKE', '%'.$value.'%');
	                    	else
	                    		$query->where($key, $value);
	                    }
	                })->whereDate('created_at', $request->date)->latest()->paginate();
            }
            else {
            	return Reception::with(['user', 'document'])
	                ->whereHas('document', function($query) use ($conditions) {
	                    foreach ($conditions as $key => $value) {
	                    	if ($key == 'name')
	                    		$query->where($key, 'LIKE', '%'.$value.'%');
	                    	else
	                    		$query->where($key, $value);
	                    }
	                })->latest()->paginate();
            }
        }

        // IMPORT
		if ($model == 'import') {
			if ($request->date != '') {
	            return Reception::with('document')
	                ->whereHas('document', function($query) use ($conditions) {
	                    foreach ($conditions as $key => $value) {
	                    	if ($key == 'name')
	                    		$query->where($key, 'LIKE', '%'.$value.'%');
	                    	else
	                    		$query->where($key, $value);
	                    }
	                })->where('scanned', true)->whereDate('date_scan', $request->date)->latest()->paginate();
            }
            else {
            	return Reception::with('document')
	                ->whereHas('document', function($query) use ($conditions) {
	                    foreach ($conditions as $key => $value) {
	                    	if ($key == 'name')
	                    		$query->where($key, 'LIKE', '%'.$value.'%');
	                    	else
	                    		$query->where($key, $value);
	                    }
	                })->where('scanned', true)->latest()->paginate();
            }
        }

        // AFFECT
        if ($model == 'affect') {
			if ($request->date != '') {
	            return Reception::with('document')
	                ->whereHas('document', function($query) use ($conditions) {
	                    foreach ($conditions as $key => $value) {
	                    	if ($key == 'name')
	                    		$query->where($key, 'LIKE', '%'.$value.'%');
	                    	else
	                    		$query->where($key, $value);
	                    }
	                })->where('imported', true)->whereDate('date_import', $request->date)->latest()->paginate();
            }
            else {
            	return Reception::with('document')
	                ->whereHas('document', function($query) use ($conditions) {
	                    foreach ($conditions as $key => $value) {
	                    	if ($key == 'name')
	                    		$query->where($key, 'LIKE', '%'.$value.'%');
	                    	else
	                    		$query->where($key, $value);
	                    }
	                })->where('imported', true)->latest()->paginate();
            }
        }

        // AFFECT
        if ($model == 'clipping') {
			if ($request->date != '') {
	            return Reception::with('document')
	                ->whereHas('document', function($query) use ($conditions) {
	                    foreach ($conditions as $key => $value) {
	                    	if ($key == 'name')
	                    		$query->where($key, 'LIKE', '%'.$value.'%');
	                    	else
	                    		$query->where($key, $value);
	                    }
	                })->where('clipped', true)->whereDate('date_clipping', $request->date)->latest()->paginate();
            }
            else {
            	return Reception::with('document')
	                ->whereHas('document', function($query) use ($conditions) {
	                    foreach ($conditions as $key => $value) {
	                    	if ($key == 'name')
	                    		$query->where($key, 'LIKE', '%'.$value.'%');
	                    	else
	                    		$query->where($key, $value);
	                    }
	                })->where('clipped', true)->latest()->paginate();
            }
        }
	}

}