<?php

//
//public function import()
//{
//
//
//
//
//    $uploadFile = Input::file('import_file');
//
//    if(null == $uploadFile) {
//        session()->flash('danger', 'Vul een Excel sheet in');
//        return back();
//    }
//
//    $path = $uploadFile->getRealPath();
//
//    $tokens = Exacttoken::find(1);
//
//    $select = '$select';
//    $filter = '$filter';
//    $expand = '$expand';
//
//    $data = Excel\Facades\Excel::load($path, function($reader) use($tokens,$select,$filter,$expand){
//
//        $resultsImport = $reader->get()->toArray();
//
//
//        $counter = 0;
//
//        foreach ($resultsImport as $val){
//
//
//
//            if ($counter % 300 == 0) {
//                $tokens = Exacttoken::find(1);
//            }
//
//
//            $counter++;
//
//
//            //Klant Relatie nummer
//            $code = substr_replace($val['code'],'',-1,0);
//
//            //benodigde spaties toevoegen aan code
//            $codeLength = strlen(substr_replace($val['code'],'',-1,0));
//
//            $spacesToAdd = 18 - $codeLength;
//
//            $spaces = '';
//
//            for ($x = 0; $x < $spacesToAdd; $x++) {
//                $spaces = $spaces . '+';
//            }
//
//            $urlFriendlyCode = $spaces . $code;
//
//            $tokenxmlheader[1] = "Authorization: Bearer $tokens->accesstoken";
//            $tokenxmlheader[2] = "Content-Type: application/json";
//            $tokenxmlheader[3] = "Accept: application/json";
//            $tokenxmlheader[4] = "Cache-Control: private";
//            $tokenxmlheader[5] = "Connection: Keep-Alive";
//            $url = "https://start.exactonline.nl/api/v1/875801/crm/Accounts?$filter=Code+eq+'$urlFriendlyCode'";
//            $curl = curl_init();
//            curl_setopt($curl,CURLOPT_HTTPGET,TRUE);
//            curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
//            curl_setopt($curl,CURLOPT_HTTPHEADER,$tokenxmlheader);
//            curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
//            curl_setopt($curl,CURLOPT_URL,$url);
//            $result = curl_exec($curl);
//            if (!empty(curl_error($curl))) echo "CURL_ERROR: " . curl_error($curl) . "<br/>";
//            curl_close($curl);
//
//            $result = json_decode($result);
//
//
//            //Alleen doorgaan als REQUEST data bevat
//            if(isset($result->d->results[0])){
//
//
//                $ID = $result->d->results[0]->ID;
//                //dd($result->d->results[0]->ID);
//
//
//                $tokenxmlheader[1] = "Authorization: Bearer $tokens->accesstoken";
//                $tokenxmlheader[2] = "Content-Type: application/json";
//                $tokenxmlheader[3] = "Accept: application/json";
//                $tokenxmlheader[4] = "Cache-Control: private";
//                $tokenxmlheader[5] = "Connection: Keep-Alive";
//                $url = "https://start.exactonline.nl/api/v1/875801/salesinvoice/SalesInvoices?$filter=DeliverTo+eq+guid'$ID'&$select=SalesInvoiceLines,OrderDate&$expand=SalesInvoiceLines";
//                $curl = curl_init();
//                curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
//                curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
//                curl_setopt($curl, CURLOPT_HTTPHEADER, $tokenxmlheader);
//                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
//                curl_setopt($curl, CURLOPT_URL, $url);
//                $result2 = curl_exec($curl);
//                if (!empty(curl_error($curl))) echo "CURL_ERROR: " . curl_error($curl) . "<br/>";
//                curl_close($curl);
//
//                $result2 = json_decode($result2);
//
//
//                $bestelgeschiedenis = ';';
////                        dd($result2);
//
//                $lastOrder = '';
////                  dd($result2->d->results[0]->SalesInvoiceLines->results);
//                if(isset($result2->d->results)){
//
//                    $invoiceDatesplusLines = $result2->d->results;
//
//                    foreach ($invoiceDatesplusLines as $invoice){
//
//                        //De datum
//                        $orderDate = $invoice->OrderDate;
//
//
//
//                        //Get last order info
//                        $lastOrder = $invoice;
//
//                        foreach ($invoice->SalesInvoiceLines->results as $line){
//                            //Item names
////                                    dd($line->ItemDescription);
//
//                            $bestelgeschiedenis .= $line->ItemDescription . ';';
//
//
//                            if ($line === end($invoice->SalesInvoiceLines->results)){
////                                        dd($line);
//                            }
//                        }
//                    }
//
//                }
//
//            }
//
//            if($orderDate){
//                $krijg = substr_replace($orderDate, "", 0, 6);
//
//                $epoch = substr_replace($krijg, "", -5);
//
//                $invoicedatum = date('Y-m-d', intval($epoch));
//            }
//
//
//
//            $totalProducts = '';
//
//            if(isset($lastOrder->SalesInvoiceLines->results)){
//                foreach ($lastOrder->SalesInvoiceLines->results as $lastOrderItem){
//
//                    $totalProducts .= $lastOrderItem->ItemDescription . ';';
//
//                }
//            }
//
//            $insert[] = [
//                'name' => $val['name'],
//                'email' => $val['email'],
//                'phone' => $val['phone'],
//                'Street Address' => $val['addressline1'],
//                'country' => $val['countrydescription'],
//                'city' => $val['city'],
//                'bestel Geschiedenis' => $bestelgeschiedenis,
//                'Order datum' => $invoicedatum,
//                'Total products' => $totalProducts
//
//            ];
//
//            /*
//            $val['name']
//            $val['email']
//            $val['phone']
//            $val['addressline1']
//            $val['countrydescription']
//            $val['city']
//            */
//
//        }
//
//
//        if(!empty($insert)){
//
//            Excel\Facades\Excel::create('Aangevulde Exact gegevens', function ($excel) use ($insert) {
//
//                // Set the title
//                $excel->setTitle('Klantgegevens');
//
//                // Chain the setters
//                $excel->setCreator('Team 9')
//                    ->setCompany('Dorivit');
//
//                // Call them separately
//                $excel->setDescription('Klantgegevens');
//
//                $excel->sheet('Sheetname', function ($sheet) use ($insert) {
//
//
//
//                    $sheet->fromArray($insert);
//
//                });
//
//
//            })->download('xls');
//
//
//        }
//
//
//
//    });
//
//    session()->flash('succes', 'Marketing lijst geexporteerd!');
//
//    return back();
//
//}
//
//
//public function refresh(){
//
//
//
//    $tokens = Exacttoken::find(1);
//
//
//    $url = 'https://start.exactonline.nl/api/oauth2/token';
//    $params = array(
//        "refresh_token" => $tokens->refreshtoken,
//        "client_id" => env('EXACT_CLIENT_ID'),
//        "client_secret" => env('EXACT_CLIENT_SECRET'),
//        "grant_type" => "refresh_token"
//    );
//
//    $curl = curl_init();
//    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
//    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE
//    );
//    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
//    curl_setopt($curl, CURLOPT_URL, $url);
//    $json_response = curl_exec($curl);
//    if (!empty(curl_error($curl))) echo "CURL_ERROR: " . curl_error($curl) . "<br/>";
//    curl_close($curl);
//    $result = json_decode($json_response);
//
//
//    $accesstoken = $result->access_token;
//    $refreshtoken = $result->refresh_token;
//
//    $tokens->accesstoken = $accesstoken;
//    $tokens->refreshtoken = $refreshtoken;
//
//    $tokens->save();
//}


//
//namespace App\Http\Controllers;
//
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Input;
//use App\Customer;
//use App\Marketinglist;
//use App\Events\NewList;
//use Maatwebsite\Excel;
//
//
//
//
//
//
//class ExcelController extends Controller
//{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }
//
//
//    public function importIndex(){
//
//        return view('excel/import');
//
//    }
//
//    public function importExcel(Request $request){
//
//        $validatedData = $request->validate([
//            'name' => 'required'
//        ]);
//
//        $uploadFile = Input::file('import_file');
//
//        if(null == $uploadFile) {
//            session()->flash('danger', 'Vul een Excel sheet in');
//            return back();
//        }
//
//        $path = $uploadFile->getRealPath();
//
//        $lists = Marketinglist::get()->where('name',$request->get('name'))->count();
//
//        if($lists <= 0){
//
//            $marketingList = Marketinglist::create([
//                'name' => $request->get('name')
//            ]);
//
//            event(new NewList($marketingList));
//
//
//            $data = Excel\Facades\Excel::load($path, function($reader) use ($marketingList) {
//
//
//                $results = $reader->get()->toArray();
//
//                foreach ($results as $val){
//
//                    //Get Retour information
//                    $name = rawurlencode($val['relatie_naam']);
//
//                    $url = 'http://localhost:81/eol/api/customers/'. $name;
//                    $curl = curl_init();
//                    curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
//                    curl_setopt($curl,CURLOPT_URL,$url);
//                    $result = curl_exec($curl);
//                    if (!empty(curl_error($curl))) echo "CURL_ERROR: " . curl_error($curl) . "<br/>";
//                    curl_close($curl);
//                    $result = json_decode($result);
//
//                    foreach ($result as $res){
//                        dd($res->invoice_name);
//                    }
//
//                    $insert[] = [
//                        'name' => $val['relatie_naam'],
//                        'e-mail' => $val['e_mail'],
//                        'marketinglist_id' => $marketingList->id,
//                        'telefoon' => $val['telefoon'],
//                        'mobiel' => $val['mobiel']
//                    ];
//                }
//
//                if(!empty($insert)){
//
//                    foreach ($insert as $item){
//
//                        $createCustomer = Customer::create([
//                            'name' => $item['name'],
//                            'marketinglist_id' => $item['marketinglist_id'],
//                            'e-mail' => $item['e-mail'],
//                            'telefoon' => $item['telefoon'],
//                            'mobiel' => $item['mobiel'],
//                        ]);
//
//                    }
//                }
//
//
//            });
//
//        } else {
//            session()->flash('danger', 'Naam bestaat al');
//            return back();
//        }
//
//        session()->flash('succes', 'Marketing lijst toegevoegd aan de database!');
//
//        return back();
//
//    }
//}
