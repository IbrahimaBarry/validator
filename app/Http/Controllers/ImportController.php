<?php

namespace App\Http\Controllers;

use App\Import;
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
        return ['imports' => Import::with(['scan.user', 'scan.reception.document'])->latest()->paginate(20), 
                'role' => Auth::user()->role];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function importing($id)
    {
        $import = Import::find($id);
        $import->user_id = Auth::user()->id;
        $import->imported = true;
        $import->save();
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm($id)
    {
        $import = Import::find($id);
        $import->admin = Auth::user()->name;
        $import->confirmed = true;
        $import->save();

        // $import->import()->create([]);
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
