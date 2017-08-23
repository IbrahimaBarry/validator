<?php

namespace App\Http\Controllers;

use App\Scan;
use App\Reception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Reception::with(['user', 'document'])->where('scanned', false)->latest()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        $reception = Reception::find($id);
        $reception->scanned = true;
        $reception->save();

        $scan = new Scan();
        $scan->user_id = Auth::user()->id;
        $scan->document_id = $reception->document->id;
        $scan->reception_id = $id;

        $scan->save();

        return Reception::with(['user', 'document'])->where('scanned', false)->latest()->paginate(5);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Scan  $scan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scan $scan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Scan  $scan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
