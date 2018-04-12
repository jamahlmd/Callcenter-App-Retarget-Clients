<?php

namespace App\Http\Controllers;

use App\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sale(Customer $customer){

        $customer->status = 3;  //3 = Sale

        $customer->save();

        return back();
    }

    public function reject(Customer $customer){


        $customer->status = 2;  //2 = Reject

        $customer->save();

        return back();
    }

    public function trash(Customer $customer){

        $customer->status = 4;  //4 = Thrash

        $customer->save();

        return back();
    }

    public function frans(Customer $customer){

        $customer->status = 6;  //6 = Frans

        $customer->save();

        return back();
    }


    public function afspraak(Request $request,Customer $customer){

        $date = $request->get('date');
        $date = Carbon::parse($date)->format('Y-m-d H:i:s');
        $note = $request->get('note');

        $customer->status = 1; //1 = Terugbellen
        $customer->afspraak = $date;
        $customer->opmerking =$note;

        $customer->save();

        return back();
    }

    public function nietopgenomen(Customer $customer){

        $customer->status = 5;  //6 = Frans

        $latestDate = Customer::select('afspraak')->orderBy('afspraak', 'ASC')->get()->first();

        $newDate = Carbon::parse($latestDate->afspraak)->subHour(1);

        $customer->afspraak = $newDate;

        $customer->save();

        return back();
    }

}
