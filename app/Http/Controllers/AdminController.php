<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\History;

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
    
    public function histories() {
		return History::with('user')->latest()->paginate();
    }
}
