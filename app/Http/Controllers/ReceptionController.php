<?php

namespace App\Http\Controllers;

use App\Reception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Document;
use Carbon\Carbon;
use App\User;
use App\Helpers\Sort;

class ReceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Reception::with(['user', 'document'])->latest()->paginate();
                    // ->whereDate('created_at', '>', Carbon::today()->subWeek()->toDateString())->latest()->get();
    }

    // SCAN
    public function scan($id)
    {
        $reception = Reception::find($id);

        $reception->date_scan = Carbon::now();
        $reception->scanned = true;
        $reception->user_scan = Auth::user()->name;

        $reception->save();

        return Reception::with(['user', 'document'])->latest()->paginate();
    }

    // IMPORT
    public function getScanned()
    {
        return Reception::with('document')->where('scanned', true)->latest()->paginate();
    }

    public function import($id)
    {
        $reception = Reception::find($id);

        $reception->date_import = Carbon::now();
        $reception->imported = true;
        $reception->user_import = Auth::user()->name;

        $reception->save();

        return Reception::with('document')->where('scanned', true)->latest()->paginate();
    }

    // AFFECT
    public function getImported()
    {
        $agents = [];

        foreach (User::where('role', 'agent')->get() as $user) {
            foreach ($user->permissions as $permission) {
                if ($permission->name === 'clipping')
                    array_push($agents, $user);
            }
        }
        return ['imports' => Reception::with('document')->where('imported', true)->latest()->paginate(),
                                     'agents' => $agents];
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

        return ['imports' => Reception::with('document')->where('imported', true)->latest()->paginate(),
                                     'agents' => $agents];
    }

    // CLIPPING
    public function agentClipping()
    {
        if (Auth::user()->role === 'agent')
            return Reception::with('document')
                        ->where([['user_clipping', Auth::user()->name], ['clipped', false]])->latest()->get();
        else
            return Reception::with('document')
                        ->where([['imported', true], ['clipped', false]])->latest()->get();
    }

    public function clipping(Request $request ,$id)
    {
        $reception = Reception::find($id);

        $reception->user_clipping = Auth::user()->name;
        $reception->date_clipping = Carbon::now();
        $reception->nbrArtTotal = $request->nbrArtTotal;
        $reception->time = $request->time;
        $reception->clipped = true;

        $reception->save();

        if (Auth::user()->role === 'agent')
            return Reception::with('document')
                        ->where([['user_clipping', Auth::user()->name], ['clipped', false]])->latest()->get();
        else
            return Reception::with('document')
                        ->where([['imported', true], ['clipped', false]])->latest()->get();
    }

    // EXPORT
    public function export($id)
    {
        $reception = Reception::find($id);

        $reception->user_export = Auth::user()->name;
        $reception->date_export = Carbon::now();
        $reception->exported = true;

        $reception->save();

        return Reception::with('document')->where('clipped', true)->latest()->paginate();
    }

    public function getClipped()
    {
        return Reception::with('document')->where('clipped', true)->latest()->paginate();
    }

    public function deleteClipping($id) {
        $reception = Reception::findOrFail($id);

        $reception->clipped = false;
        $reception->save();

        return Reception::with('document')->where('clipped', true)->latest()->paginate();
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
        $reception->document_id = $request['document_id'];
        $reception->sourceDate = $request['sourceDate'];
        $reception->nbrPage = $request['nbrPage'];
        $reception->message = $request['message'];
        $reception->user_id = Auth::user()->id;
        $reception->save();

       // return Reception::with(['user', 'document'])
       //              ->whereDate('created_at', '>', Carbon::today()->subWeek()->toDateString())->latest()->get();
    }

    public function sort($model, Request $request)
    {
        if ($model == 'affect') {
            $agents = [];

            foreach (User::where('role', 'agent')->get() as $user) {
                foreach ($user->permissions as $permission) {
                    if ($permission->name === 'clipping')
                        array_push($agents, $user);
                }
            }

            return ['imports' => (new Sort())->index($model, $request), 'agents' => $agents];
        }
        else
            return (new Sort())->index($model, $request);
    }

}
