<?php

namespace App\Helpers;

use App\Reception;

/**
* Class for sorting Receptions
*/
class Sort
{
	protected $model;
	
	function index($model, $request)
	{
		$this->model = $model;

		if ($this->model == 'reception') {
			$tab = [];
			foreach ($request as $req) {
				array_push($tab, ['document.'$req.name, $req.value]);
			}
			return Reception::with(['user', 'document'])
					->where($tab)->latest()->paginate(10);
		}
	}

}