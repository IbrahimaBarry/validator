<?php

namespace App\Http\Controllers;

use App\Reception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTimeZone;
use App\User;
use App\Helpers\Sort;

class ReceptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    /**
     * The resource SCAN.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function scan($id)
    {
        $reception = Reception::find($id);

        $reception->date_scan = Carbon::now(new DateTimeZone('Africa/Casablanca'));
        $reception->scanned = true;
        $reception->user_scan = Auth::user()->name;

        $reception->save();

        return Reception::with(['user', 'document'])->latest()->paginate();
    }

    /**
     * Display a listing of the resource SCANNED.
     *
     * @return \Illuminate\Http\Response
     */
    public function getScanned()
    {
        return Reception::with('document')->where('scanned', true)->latest()->paginate();
    }

    /**
     * The resource IMPORT.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import($id)
    {
        $reception = Reception::find($id);

        $reception->date_import = Carbon::now(new DateTimeZone('Africa/Casablanca'));
        $reception->imported = true;
        $reception->user_import = Auth::user()->name;

        $reception->save();

        return Reception::with('document')->where('scanned', true)->latest()->paginate();
    }

     /**
     * Display a listing of the resource IMPORTED.
     *
     * @return \Illuminate\Http\Response
     */
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

     /**
     * Affect a clipping agent to an IMPORTED document.
     *
     * @param  int  $reception_id
     * @param  int  $agent_id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display a listing of the resource AFFECTED to the current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function agentClipping()
    {
        if (Auth::user()->role === 'agent')
            return Reception::with('document')
                        ->where([['user_clipping', Auth::user()->name], ['clipped', false]])->latest()->get();
        else
            return Reception::with('document')
                        ->where([['imported', true], ['clipped', false]])->latest()->get();
    }

    /**
     * The resource CLIPPING.
     *
     * @param  Illuminate\Http\Request  $request;
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function clipping(Request $request ,$id)
    {
        $reception = Reception::find($id);

        $reception->user_clipping = Auth::user()->name;
        $reception->date_clipping = Carbon::now(new DateTimeZone('Africa/Casablanca'));
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

    /**
     * The resource EXPORT.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export($id)
    {
        $reception = Reception::find($id);

        $reception->user_export = Auth::user()->name;
        $reception->date_export = Carbon::now(new DateTimeZone('Africa/Casablanca'));
        $reception->exported = true;

        $reception->save();

        return Reception::with('document')->where('clipped', true)->latest()->paginate();
    }

     /**
     * Display a listing of the resource CLIPPED.
     *
     * @return \Illuminate\Http\Response
     */
    public function getClipped()
    {
        return Reception::with('document')->where('clipped', true)->latest()->paginate();
    }

    /**
     * Remove the specified resource CLIPPED from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        foreach ($request->request as $req) {
            $reception = new Reception();
            $reception->document_id = $req['document_id'];
            $reception->sourceDate = $req['sourceDate'];
            $reception->nbrPage = $req['nbrPage'];
            $reception->message = $req['message'];
            $reception->user_id = Auth::user()->id;
            $reception->save();
        }

        return Reception::with(['user', 'document'])->latest()->paginate();
    }

    /**
     * Sort the listed resources.
     *
     * @param  string  $model
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
