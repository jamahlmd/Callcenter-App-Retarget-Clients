<?php

namespace App\Http\Controllers;

use App\Marketinglist;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use JavaScript;


class BellijstController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public function index(){

        $user = Auth::user();
        if ($user) {
            JavaScript::put([
                'agent' => $user->name
            ]);
        }

        $lijsten = Marketinglist::all();

        return view('agent/index', compact('lijsten'));
    }

    public function fetchLists(){

         return Marketinglist::all();
    }

    public function setAgent(Request $request, Marketinglist $marketinglist){

        $marketinglist->agent = $request->get('agent');

        $marketinglist->save();

        return response()->json($marketinglist, 200);
    }



    public function bellen(Marketinglist $marketinglist){

        $klanten = $marketinglist->customers;

        return view('agent/bellen', compact('klanten'));
    }
}
