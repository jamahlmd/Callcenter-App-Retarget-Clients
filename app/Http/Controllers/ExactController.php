<?php




namespace App\Http\Controllers;

use App\Exacttoken;
use App\Exceptions\ApiError;
use App\HubspotContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel;






class ExactController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function login(){

        //authorization log in
        $params = array("response_type" => "code",
            "client_id" => env('EXACT_CLIENT_ID'),
            "redirect_uri" => env('EXACT_REDIRECT_URI'),
        );
        $url = "https://start.exactonline.nl/api/oauth2/auth" . '?' . http_build_query($params);

        redirect()->to($url)->send();
    }

    public function response(){
        if(null !== (Input::get('code'))){
            $code = Input::get('code');

            $url = 'https://start.exactonline.nl/api/oauth2/token';
            $params = array(
                "grant_type" => "authorization_code",
                "client_id" => env('EXACT_CLIENT_ID'),
                "client_secret" => env('EXACT_CLIENT_SECRET'),
                "redirect_uri" => env('EXACT_REDIRECT_URI'),
                "code" => $code
            );
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_URL, $url);
            $json_response = curl_exec($curl);
            if (!empty(curl_error($curl))) echo "CURL_ERROR: " . curl_error($curl) . "<br/>";
            curl_close($curl);

            $result = json_decode($json_response);

//            dd($result);

            $access_token = $result->access_token;
            $refresh_token = $result->refresh_token;

            $tokens = Exacttoken::find(1);

            $tokens->accesstoken = $access_token;
            $tokens->refreshtoken = $refresh_token;

            $tokens->save();

            //Choose between databases
            $tokenxmlheader[1] = "Authorization: Bearer $access_token";
            $tokenxmlheader[2] = "Content-Type: application/xml";
            $tokenxmlheader[3] = "Accept: application/xml";
            $tokenxmlheader[4] = "Cache-Control: private";
            $tokenxmlheader[5] = "Connection: Keep-Alive";
            $url = "https://start.exactonline.nl/docs/XMLDivisions.aspx";
            $curl = curl_init();
            curl_setopt($curl,CURLOPT_HTTPGET,TRUE);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
            curl_setopt($curl,CURLOPT_HTTPHEADER,$tokenxmlheader);
            curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
            curl_setopt($curl,CURLOPT_URL,$url);
            $result = curl_exec($curl);
            if (!empty(curl_error($curl))) echo "CURL_ERROR: " . curl_error($curl) . "<br/>";
            curl_close($curl);
            $xml = simplexml_load_string($result);



            return view('exact/verification', compact(['access_token','code','refresh_token','xml']));

        } else {
            return session()->flash('danger', 'Something went wrong');

        }
    }


    public function verify(){

        $tokens = Exacttoken::find(1);

        $tokenxmlheader[1] = "Authorization: Bearer $tokens->accesstoken";
        $tokenxmlheader[2] = "Content-Type: application/json";
        $tokenxmlheader[3] = "Accept: application/json";
        $tokenxmlheader[4] = "Cache-Control: private";
        $tokenxmlheader[5] = "Connection: Keep-Alive";
        $url = "https://start.exactonline.nl/api/v1/current/Me";
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_HTTPGET,TRUE);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($curl,CURLOPT_HTTPHEADER,$tokenxmlheader);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($curl,CURLOPT_URL,$url);
        $result = curl_exec($curl);
        if (!empty(curl_error($curl))) echo "CURL_ERROR: " . curl_error($curl) . "<br/>";
        curl_close($curl);

        $result = json_decode($result);

        //dd($result);

        if(isset($result)) {
            $division = $result->d->results[0]->CurrentDivision;

            $tokens->division = $division;

            $tokens->save();

            return view('exact/import');
        } else {
            return session()->flash('danger', 'No result/Connection');
        }
    }


    public function import()
    {




        $uploadFile = Input::file('import_file');

        if(null == $uploadFile) {
            session()->flash('danger', 'Vul een Excel sheet in');
            return back();
        }

        $path = $uploadFile->getRealPath();

        $tokens = Exacttoken::find(1);

        $select = '$select';
        $filter = '$filter';
        $expand = '$expand';

        $data = Excel\Facades\Excel::load($path, function($reader) use($tokens,$select,$filter,$expand){

                $resultsImport = $reader->get()->toArray();

            
                    $counter = 0;
            
                foreach ($resultsImport as $val){



                  if ($counter % 300 == 0) {
                    $tokens = Exacttoken::find(1);
                    }


                    $counter++;


                    //Klant Relatie nummer
                    $code = substr_replace($val['code'],'',-1,0);

                    //benodigde spaties toevoegen aan code
                    $codeLength = strlen(substr_replace($val['code'],'',-1,0));

                    $spacesToAdd = 18 - $codeLength;

                    $spaces = '';

                    for ($x = 0; $x < $spacesToAdd; $x++) {
                        $spaces = $spaces . '+';
                    }

                    $urlFriendlyCode = $spaces . $code;

                    $tokenxmlheader[1] = "Authorization: Bearer $tokens->accesstoken";
                    $tokenxmlheader[2] = "Content-Type: application/json";
                    $tokenxmlheader[3] = "Accept: application/json";
                    $tokenxmlheader[4] = "Cache-Control: private";
                    $tokenxmlheader[5] = "Connection: Keep-Alive";
                    $url = "https://start.exactonline.nl/api/v1/875801/crm/Accounts?$filter=Code+eq+'$urlFriendlyCode'";
                    $curl = curl_init();
                    curl_setopt($curl,CURLOPT_HTTPGET,TRUE);
                    curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
                    curl_setopt($curl,CURLOPT_HTTPHEADER,$tokenxmlheader);
                    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
                    curl_setopt($curl,CURLOPT_URL,$url);
                    $result = curl_exec($curl);
                    if (!empty(curl_error($curl))) echo "CURL_ERROR: " . curl_error($curl) . "<br/>";
                    curl_close($curl);

                    $result = json_decode($result);


                    //Alleen doorgaan als REQUEST data bevat
                    if(isset($result->d->results[0])) {


                        $ID = $result->d->results[0]->ID;
                        //dd($result->d->results[0]->ID);


                        $tokenxmlheader[1] = "Authorization: Bearer $tokens->accesstoken";
                        $tokenxmlheader[2] = "Content-Type: application/json";
                        $tokenxmlheader[3] = "Accept: application/json";
                        $tokenxmlheader[4] = "Cache-Control: private";
                        $tokenxmlheader[5] = "Connection: Keep-Alive";
                        $url = "https://start.exactonline.nl/api/v1/875801/salesinvoice/SalesInvoices?$filter=DeliverTo+eq+guid'$ID'&$select=SalesInvoiceLines,OrderDate&$expand=SalesInvoiceLines";
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, $tokenxmlheader);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                        curl_setopt($curl, CURLOPT_URL, $url);
                        $result2 = curl_exec($curl);
                        if (!empty(curl_error($curl))) echo "CURL_ERROR: " . curl_error($curl) . "<br/>";
                        curl_close($curl);

                        $result2 = json_decode($result2);


                        $bestelgeschiedenis = ';';
//                        dd($result2);

                        $orderDate = '';
                        $lastOrder = '';
//                  dd($result2->d->results[0]->SalesInvoiceLines->results);
                        if (isset($result2->d->results)) {

                            $invoiceDatesplusLines = $result2->d->results;

                            foreach ($invoiceDatesplusLines as $invoice) {

                                //De datum
                                $orderDate = $invoice->OrderDate;


                                //Get last order info
                                $lastOrder = $invoice;

                                foreach ($invoice->SalesInvoiceLines->results as $line) {
                                    //Item names
//                                    dd($line->ItemDescription);

                                    $bestelgeschiedenis .= $line->ItemDescription . ';';


                                    if ($line === end($invoice->SalesInvoiceLines->results)) {
//                                        dd($line);
                                    }
                                }
                            }

                        }


                        if ($orderDate) {
                            $krijg = substr_replace($orderDate, "", 0, 6);

                            $epoch = substr_replace($krijg, "", -5);

                            $invoicedatum = date('Y-m-d', intval($epoch));
                        }


                        $totalProducts = '';

                        if (isset($lastOrder->SalesInvoiceLines->results)) {
                            foreach ($lastOrder->SalesInvoiceLines->results as $lastOrderItem) {

                                $totalProducts .= $lastOrderItem->ItemDescription . ';';

                            }
                        }


                        HubspotContact::create([
                            'name' => $val['name'],
                            'email' => $val['email'],
                            'phone' => $val['phone'],
                            'StreetAddress' => $val['addressline1'],
                            'country' => $val['countrydescription'],
                            'city' => $val['city'],
                            'bestelGeschiedenis' => $bestelgeschiedenis,
                            'Orderdatum' => $invoicedatum,
                            'Totalproducts' => $totalProducts
                        ]);


                    } else {
                        throw new ApiError('BRROKOOOOOOOOO');
                    }

                }
            





            });

        session()->flash('succes', 'Marketing lijst geexporteerd!');

        return back();

    }


    public function refresh(){



        $tokens = Exacttoken::find(1);


        $url = 'https://start.exactonline.nl/api/oauth2/token';
        $params = array(
            "refresh_token" => $tokens->refreshtoken,
            "client_id" => env('EXACT_CLIENT_ID'),
            "client_secret" => env('EXACT_CLIENT_SECRET'),
            "grant_type" => "refresh_token"
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_URL, $url);
        $json_response = curl_exec($curl);
        if (!empty(curl_error($curl))) echo "CURL_ERROR: " . curl_error($curl) . "<br/>";
        curl_close($curl);
        $result = json_decode($json_response);


        $accesstoken = $result->access_token;
        $refreshtoken = $result->refresh_token;

        $tokens->accesstoken = $accesstoken;
        $tokens->refreshtoken = $refreshtoken;

        $tokens->save();
    }


    public function download(){

        $contacts = HubspotContact::all();

        Excel\Facades\Excel::create('Aangevulde Exact gegevens', function ($excel) use ($contacts) {

                // Set the title
                $excel->setTitle('Klantgegevens');

                // Chain the setters
                $excel->setCreator('Team 9')
                    ->setCompany('Dorivit');

                // Call them separately
                $excel->setDescription('Klantgegevens');

                $excel->sheet('Sheetname', function ($sheet) use ($contacts) {


                    $sheet->fromArray($contacts);

                });


            })->download('xls');






        return back();

    }

}
