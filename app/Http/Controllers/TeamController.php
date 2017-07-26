<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;

class TeamController extends Controller
{
    public function index()
    {
    	return Team::latest()->get();
    }

    public function store(Request $request)
    {
    	Team::create($request->all());

    	return Team::latest()->get();
    }
}
