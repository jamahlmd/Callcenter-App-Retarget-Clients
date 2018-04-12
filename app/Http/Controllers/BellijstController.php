<?php

namespace App\Http\Controllers;

use App\Marketinglist;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use JavaScript;
use App\Events\setBusy;
use App\Events\setNotBusy;





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

        event(new setBusy($request->get('id'),$request->get('agent')));

        $marketinglist->agent = $request->get('agent');

        $marketinglist->save();

        return response()->json($marketinglist, 200);
    }



    public function bellen(Marketinglist $marketinglist){


        $user = Auth::user();
        if ($user) {
            if(!$marketinglist->agent || $marketinglist->agent === $user->name)
            {

                $klanten = $marketinglist->customers;

                //Zet klant voor de view
                $klant = $klanten->first();

                if($klant){
                    //Zet retouren van klant erbij
                    $retouren = $klant->retours;
                }


                //Zet marktelinglist ID voor Navlink
                $id = $marketinglist->id;




//                dd($klanten);

//                JavaScript::put([
//                    'id' => $marketinglist->id
//                ]);

                //Om refresh te filteren
//                event(new setBusy($marketinglist->id,$user->name));
//
//                $marketinglist->agent = $user->name;
//
//                $marketinglist->save();

                return view('agent/bellen', compact(['klant','retouren','id','marketinglist']));
            }
        }



        session()->flash('danger', 'Lijst is al bezet');
        return back();

    }


    public function setNotBusy(Marketinglist $marketinglist){

        $marketinglist->agent = null;

        $marketinglist->save();

        event(new setNotBusy($marketinglist->id,null));

        return Redirect::to('/bellijstkiezen');


    }
}
