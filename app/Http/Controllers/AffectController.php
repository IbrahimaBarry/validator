<?php

namespace App\Http\Controllers;

use App\Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Sort;

class AffectController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Import::with(['user', 'scan.user', 'scan.reception.document'])
        		->where([['confirmed', true], ['affected', false]])->latest()->paginate(20);
    }

    /**
     *  Affect the imported resssource to an agent
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function affect($id)
    {
        $doc = Import::find($id);

        if (!$doc->affected) {
            $doc->clipping()->create(['user_id' => Auth::user()->id]);
            $doc->affected = true;
            $doc->save();

            return ['type' => 'success', 'message' => 'Ce document vous a été affecté!'];
        }
        else
            return ['type' => 'error', 'message' => 'Ce document a déja été affecté!'];
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
        return (new Sort($request))->affect($request);
    }
}
