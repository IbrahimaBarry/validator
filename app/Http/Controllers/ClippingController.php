<?php

namespace App\Http\Controllers;

use App\Clipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClippingController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	if (Auth::user()->role == 'agent') {
    		$clippings = Clipping::with('import.scan.reception.document')
        					->where([['user_id', Auth::user()->id], ['confirmed', false]])->latest()->get();
    	}
    	else {
    		$clippings = Clipping::with('import.scan.reception.document')
        					->where('confirmed', false)->latest()->get();
    	}
        return ['clippings' => $clippings, 'role' => Auth::user()->role];
    }
}
