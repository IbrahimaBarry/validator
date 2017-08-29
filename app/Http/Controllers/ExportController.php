<?php

namespace App\Http\Controllers;

use App\Export;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Sort;

class ExportController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return ['exports' => Export::with(['clipping.user', 'clipping.import.scan.reception.document'])
    				->latest()->paginate(20), 'role' => Auth::user()->role];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exported($id)
    {
    	$export = Export::find($id);
    	$export->user_id = Auth::user()->id;
    	$export->exported = true;
    	$export->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm($id)
    {
    	$export = Export::find($id);
    	$export->admin = Auth::user()->name;
    	$export->confirmed = true;
    	$export->save();
    }

    /**
     * Sort the listed resources.
     *
     * @param  string  $model
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        return (new Sort($request))->export($request);
    }
}
