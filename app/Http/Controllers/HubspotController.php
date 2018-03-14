<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class HubspotController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function login(){

        //Hubspot log in
        $params = array(
            "client_id" => env('HUBSPOT_CLIENT_ID'),
            "scope" => "contacts",
            "redirect_uri" => env('HUBSPOT_REDIRECT_URI'),
        );
        $url = "https://app.hubspot.com/oauth/authorize" . '?' . http_build_query($params);

        redirect()->to($url)->send();
    }


    public function response(){
        if(null !== (Input::get('code'))){
            $code = Input::get('code');


            $url = 'https://app.hubspot.com/oauth/v1/token';
            $params = array(
                "grant_type" => "authorization_code",
                "client_id" => env('HUBSPOT_CLIENT_ID'),
                "client_secret" => env('HUBSPOT_CLIENT_SECRET'),
                "redirect_uri" => env('HUBSPOT_REDIRECT_URI'),
                "code" => $code
            );
            $tokenxmlheader[1] = "Content-Type: application/x-www-form-urlencoded";
            $tokenxmlheader[2] = "charset: utf-8";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl,CURLOPT_HTTPHEADER,$tokenxmlheader);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_URL, $url);
            $json_response = curl_exec($curl);
            if (!empty(curl_error($curl))) echo "CURL_ERROR: " . curl_error($curl) . "<br/>";
            curl_close($curl);
            $result = json_decode($json_response);

            dd($result);

            $access_token = $result->access_token;
            $refresh_token = $result->refresh_token;

            $tokens = Token::find(1);

            $tokens->access_token = $access_token;
            $tokens->refresh_token = $refresh_token;

            $tokens->save();

        }
    }
}
