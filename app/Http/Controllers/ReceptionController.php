<?php

namespace App\Http\Controllers;

use App\Reception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTimeZone;
use App\User;
use App\Scan;
use App\Helpers\Sort;

class ReceptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Affiche la liste des receptions
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Reception::with(['user', 'document'])->latest()->paginate(20);
                    // ->whereDate('created_at', '>', Carbon::today()->subWeek()->toDateString())->latest()->get();
    }

    /**
     * 
     */


    /**
     * Enregistre une bouvelle reception.
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

            $reception->scan()->create([]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Scan  $scan
     * @return \Illuminate\Http\Response
     */
    public function update($id ,$nbrPage)
    {
        $reception = Reception::find($id);
        $reception->nbrPage = $nbrPage;
        $reception->save();
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
