<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reception;

class AdminController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function dashboard() {
		$receptions = Reception::with('document')->get();

		$chartData = [];

		$labels = ['reception', 'scanned', 'ocr', 'imported', 'clipped', 'exported'];

		for ($i=0; $i < sizeof($labels); $i++) { 
			$object = new \stdClass();
			$object->label = $labels[$i];
			$object->value = 0;
			$chartData [] = $object;
		}

		foreach ($receptions as $reception) {
			if ($reception->scanned)
				$chartData[1]->value++;
			if ($reception->ocr)
				$chartData[2]->value++;
			if ($reception->imported)
				$chartData[3]->value++;
			if ($reception->clipped)
				$chartData[4]->value++;
			if ($reception->exported)
				$chartData[5]->value++;
		}

		return ['receptions' => $receptions, 'chartData' => $chartData];
    }
}
