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

    /**
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clipped(Request $request)
    {
        $clipping = Clipping::find($request->id);
        $clipping->clipped = true;
        $clipping->nbrArtTotal = $request->nbrArtTotal;
        $clipping->time = $request->time;
        $clipping->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm($id)
    {
        $clipping = Clipping::find($id);
        $clipping->admin = Auth::user()->name;
        $clipping->confirmed = true;
        $clipping->save();

        $clipping->export()->create([]);
    }
}
