<?php

namespace App\Http\Controllers;

use App\Scan;
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
        return ['scans' => Scan::with(['user', 'reception.user', 'reception.document'])->latest()->paginate(20), 
                'role' => Auth::user()->role];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($tab)
    {
        foreach ($tab as $el) {
            $scan = new Scan();
            $scan->user_id = Auth::user()->id;
            $scan->reception_id = $el[0];
            $scan->document_id = $el[1];

            $scan->save();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function scanning($id)
    {
        $scan = Scan::find($id);
        $scan->user_id = Auth::user()->id;
        $scan->scanned = true;
        $scan->save();
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm($id)
    {
        $scan = Scan::find($id);
        $scan->admin = Auth::user()->name;
        $scan->confirmed = true;
        $scan->save();
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
