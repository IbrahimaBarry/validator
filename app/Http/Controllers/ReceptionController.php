<?php

namespace App\Http\Controllers;

use App\Reception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Document;
use Carbon\Carbon;
use App\User;

class ReceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Reception::with(['user', 'document'])->latest()->get();
    }

    /**
     *  Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scan($id)
    {
        $reception = Reception::find($id);

        $reception->date_scan = Carbon::now();
        $reception->scanned = true;
        $reception->user_scan = Auth::user()->name;

        $reception->save();

        return Reception::with(['user', 'document'])->latest()->get();
    }

    public function getScan()
    {
        return Reception::with(['document'])->where('scanned', true)->latest()->get();
    }

    /**
     *  Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import($id)
    {
        $reception = Reception::find($id);

        $reception->date_import = Carbon::now();
        $reception->imported = true;
        $reception->user_import = Auth::user()->name;

        $reception->save();

        return Reception::with(['document'])->latest()->get();
    }

    public function getImport()
    {
        $agents = [];

        foreach (User::where('role', 'agent')->get() as $user) {
            foreach ($user->permissions as $permission) {
                if ($permission->name === 'clipping')
                    array_push($agents, $user);
            }
        }
        return ['imports' => Reception::with(['document'])->where('imported', true)->latest()->get(), 'agents' => $agents];
    }

    public function addAgent($reception_id, $agent_id)
    {
        $reception = Reception::find($reception_id);
        $reception->user_clipping = User::find($agent_id)->name;
        $reception->save();

        $agents = [];

        foreach (User::where('role', 'agent')->get() as $user) {
            foreach ($user->permissions as $permission) {
                if ($permission->name === 'clipping')
                    array_push($agents, $user);
            }
        }

        return ['imports' => Reception::with(['document'])->where('imported', true)->latest()->get(), 'agents' => $agents];
    }

    public function agentClipping()
    {
        if (Auth::user()->role === 'agent')
            return Reception::with(['document'])->where('user_clipping', Auth::user()->name)->latest()->get();
        else
            return Reception::with(['document'])->where('user_clipping', '!=', null)->latest()->get();
    }

    public function clipping(Request $request ,$id)
    {
        $reception = Reception::find($id);

        $reception->clipped = true;
        $reception->date_clipping = Carbon::now();
        $reception->nbrArtTotal = $request->nbrArtTotal;
        $reception->time = $request->time;

        $reception->save();

        if (Auth::user()->role === 'agent')
            return Reception::with(['document'])->where('user_clipping', Auth::user()->name)->latest()->get();
        else
            return Reception::with(['document'])->where('user_clipping', '!=', null)->latest()->get();
    }

    public function getClipping()
    {
        return Reception::with(['document'])->where('clipped', true)->latest()->get();
    }

    public function deleteClipping($id) {
        $reception = Reception::findOrFail($id);

        $reception->clipped = false;
        $reception->save();

        return Reception::with(['document'])->where('clipped', true)->latest()->get();
    }

    public function export($id)
    {
        $reception = Reception::find($id);

        $reception->exported = true;
        $reception->user_export = Auth::user()->name;
        $reception->date_export = Carbon::now();

        $reception->save();

        return Reception::with(['document'])->where('exported', true)->latest()->get();
    }

    public function getExport()
    {
        return Reception::with(['document'])->where('exported', true)->latest()->get();
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reception = new Reception();

        $reception->user_id = Auth::user()->id;
        $reception->sourceDate = $request->sourceDate.' '.$request->time;
        $reception->nbrPage = $request->nbrPage;
        $reception->document_id = $request->document_id;
        $reception->message = $request->message;

        $reception->save();

        $document = Document::find($request->document_id);
        $document->last_reception = Carbon::now();
        $document->save();

        return Document::with(['receptions'])->latest()->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function edit(Reception $reception)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reception $reception)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reception $reception)
    {
        //
    }
}
