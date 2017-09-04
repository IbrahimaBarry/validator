<?php

namespace App\Helpers;

use App\Reception;
use App\Scan;
use App\Import;
use App\Export;

/**
* Class for sorting Receptions
*/
class Sort
{
	protected $conditions = [];

	public function __construct($request)
	{
		if ($request->search != '')
			$this->conditions['name'] = $request->search;
		if ($request->type != 'Type')
			$this->conditions['type'] = $request->type;
		if ($request->lang != 'Langue')
			$this->conditions['lang'] = $request->lang;
		if ($request->version != 'Version')
			$this->conditions['version'] = $request->version;
	}

	// SORT RECEPtiON
	public function reception($request)
	{
		$conditions = $this->conditions;

		if ($request->date != '') {
            return Reception::with(['user', 'document'])
                ->whereHas('document', function($query) use ($conditions) {
                    foreach ($conditions as $key => $value) {
                    	if ($key == 'name')
                    		$query->where($key, 'LIKE', '%'.$value.'%');
                    	else
                    		$query->where($key, $value);
                    }
                })->whereDate('created_at', $request->date)->latest()->paginate(20);
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
                })->latest()->paginate(20);
        }
	}

	// SORT SCAN
	public function scan($request)
	{
		$conditions = $this->conditions;

		if ($request->date != '') {
            return Scan::with(['reception.user', 'reception.document'])
                ->whereHas('reception.document', function($query) use ($conditions) {
                    foreach ($conditions as $key => $value) {
                    	if ($key == 'name')
                    		$query->where($key, 'LIKE', '%'.$value.'%');
                    	else
                    		$query->where($key, $value);
                    }
                })->whereDate('date_scan', $request->date)->latest()->paginate(20);
        }
        else {
        	return Scan::with(['reception.user', 'reception.document'])
                ->whereHas('reception.document', function($query) use ($conditions) {
                    foreach ($conditions as $key => $value) {
                    	if ($key == 'name')
                    		$query->where($key, 'LIKE', '%'.$value.'%');
                    	else
                    		$query->where($key, $value);
                    }
                })->latest()->paginate(20);
        }
	}

	// SORT IMPORT
	public function import($request)
	{
		$conditions = $this->conditions;

		if ($request->date != '') {
            return Import::with(['scan.user', 'scan.reception.document'])
                ->whereHas('scan.reception.document', function($query) use ($conditions) {
                    foreach ($conditions as $key => $value) {
                    	if ($key == 'name')
                    		$query->where($key, 'LIKE', '%'.$value.'%');
                    	else
                    		$query->where($key, $value);
                    }
                })->whereDate('date_import', $request->date)->latest()->paginate(20);
        }
        else {
        	return Import::with(['scan.user', 'scan.reception.document'])
                ->whereHas('scan.reception.document', function($query) use ($conditions) {
                    foreach ($conditions as $key => $value) {
                    	if ($key == 'name')
                    		$query->where($key, 'LIKE', '%'.$value.'%');
                    	else
                    		$query->where($key, $value);
                    }
                })->latest()->paginate(20);
        }
	}

	// SORT AFFECT
	public function affect($request)
	{
		$conditions = $this->conditions;

		if ($request->date != '') {
            return Import::with(['user', 'scan.user', 'scan.reception.document'])
                ->whereHas('scan.reception.document', function($query) use ($conditions) {
                    foreach ($conditions as $key => $value) {
                    	if ($key == 'name')
                    		$query->where($key, 'LIKE', '%'.$value.'%');
                    	else
                    		$query->where($key, $value);
                    }
                })->whereDate('date_import', $request->date)->latest()->paginate(20);
        }
        else {
        	return Import::with(['user', 'scan.user', 'scan.reception.document'])
                ->whereHas('scan.reception.document', function($query) use ($conditions) {
                    foreach ($conditions as $key => $value) {
                    	if ($key == 'name')
                    		$query->where($key, 'LIKE', '%'.$value.'%');
                    	else
                    		$query->where($key, $value);
                    }
                })->latest()->paginate(20);
        }
	}

	// SORT EXPORT
	public function export($request)
	{
		$conditions = $this->conditions;

		if ($request->date != '') {
            return Export::with(['clipping.user', 'clipping.import.scan.reception.document'])
                ->whereHas('clipping.import.scan.reception.document', function($query) use ($conditions) {
                    foreach ($conditions as $key => $value) {
                    	if ($key == 'name')
                    		$query->where($key, 'LIKE', '%'.$value.'%');
                    	else
                    		$query->where($key, $value);
                    }
                })->whereDate('date_clipping', $request->date)->latest()->paginate(20);
        }
        else {
        	return Export::with(['clipping.user', 'clipping.import.scan.reception.document'])
                ->whereHas('clipping.import.scan.reception.document', function($query) use ($conditions) {
                    foreach ($conditions as $key => $value) {
                    	if ($key == 'name')
                    		$query->where($key, 'LIKE', '%'.$value.'%');
                    	else
                    		$query->where($key, $value);
                    }
                })->latest()->paginate(20);
        }
	}

}