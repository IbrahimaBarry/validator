<?php

namespace App\Http\Controllers;

use App\Import;
use App\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImportController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Scan::with(['user', 'document', 'reception'])->where('imported', false)->latest()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        $scan = Scan::find($id);
        $scan->imported = true;
        $scan->save();

        $import = new Import();
        $import->user_id = Auth::user()->id;
        $import->document_id = $scan->reception->document->id;
        $import->reception_id = $scan->reception->id;
        $import->save();

        return Scan::with(['user', 'document', 'reception'])->where('imported', false)->latest()->paginate(5);
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
