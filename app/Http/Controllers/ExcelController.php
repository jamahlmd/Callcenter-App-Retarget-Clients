<?php

namespace App\Http\Controllers;

use App\Retour;
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


            $data = Excel\Facades\Excel::load($path, function($reader) use ($marketingList) {


            $results = $reader->get()->toArray();

            foreach ($results as $val){

                //Get Retour information
                $name = rawurlencode($val['relatie_naam']);

                $url = 'http://localhost:81/eol/api/customers/'. $name;
                $curl = curl_init();
                curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
                curl_setopt($curl,CURLOPT_URL,$url);
                $result = curl_exec($curl);
                if (!empty(curl_error($curl))) echo "CURL_ERROR: " . curl_error($curl) . "<br/>";
                curl_close($curl);
                $result = json_decode($result);

                            //Customer aanmaken met list id
                            $createCustomer = Customer::create([
                                'name' => $val['relatie_naam'],
                                'e-mail' => $val['e_mail'],
                                'marketinglist_id' => $marketingList->id,
                                'telefoon' => $val['telefoon'],
                                'mobiel' => $val['mobiel']
                        ]);

                            //Retouren erbij toevoegen many to many (indien die er zijn)
                            if($result){
                                foreach ($result as $res){
                                    Retour::create([
                                        'product_naam' => $res->invoice_name,
                                        'reden' => $res->reason,
                                        'datum' => $res->created_at,
                                        'customer_id' => $createCustomer->id
                                    ]);
                                }
                            }
            }

        });
            event(new NewList($marketingList));

        } else {
            session()->flash('danger', 'Naam bestaat al');
            return back();
        }

        session()->flash('succes', 'Marketing lijst toegevoegd aan de database!');

        return back();

    }
}
