<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Customer;
use App\Marketinglist;
use App\Events\NewList;
use Maatwebsite\Excel;






class ExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function importIndex(){

    return view('excel/import');

    }

    public function importExcel(Request $request){

        $validatedData = $request->validate([
            'name' => 'required'
        ]);

        $uploadFile = Input::file('import_file');

        if(null == $uploadFile) {
            session()->flash('danger', 'Vul een Excel sheet in');
            return back();
        }

        $path = $uploadFile->getRealPath();

        $lists = Marketinglist::get()->where('name',$request->get('name'))->count();

        if($lists <= 0){

             $marketingList = Marketinglist::create([
                'name' => $request->get('name')
            ]);

            event(new NewList($marketingList));


            $data = Excel\Facades\Excel::load($path, function($reader) use ($marketingList) {


            $results = $reader->get()->toArray();

            foreach ($results as $val){

                $insert[] = [
                    'name' => $val['relatie_naam'],
                    'e-mail' => $val['e_mail'],
                    'marketinglist_id' => $marketingList->id,
                    'telefoon' => $val['telefoon'],
                    'mobiel' => $val['mobiel']
                ];
            }

            if(!empty($insert)){

                foreach ($insert as $item){

                        Customer::create([
                            'name' => $item['name'],
                            'marketinglist_id' => $item['marketinglist_id'],
                            'e-mail' => $item['e-mail'],
                            'telefoon' => $item['telefoon'],
                            'mobiel' => $item['mobiel'],
                        ]);

                }
            }


        });

        } else {
            session()->flash('danger', 'Naam bestaat al');
            return back();
        }

        session()->flash('succes', 'Marketing lijst toegevoegd aan de database!');

        return back();

    }
}
