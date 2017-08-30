<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Reception;
use App\Document;
use Gate;

class HomeController extends Controller
{   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reception = Gate::allows('reception', Document::class);
        $scan = Gate::allows('scan', Reception::class);
        $import = Gate::allows('import', Reception::class);
        $clipping = Gate::allows('clipping', Reception::class);
        $export = Gate::allows('export', Reception::class);

        return ['reception' => $reception, 'scan' => $scan, 'import' => $import, 'clipping' => $clipping, 'export' => $export];
    }
}
