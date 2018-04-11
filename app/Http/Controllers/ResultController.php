<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;


class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sale(Customer $customer){


        return $customer;
    }
}
