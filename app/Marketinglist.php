<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marketinglist extends Model
{

    protected $fillable = [
        'name','product'
    ];

    public function customers(){

        return $this->hasMany(Customer::class)->where('status',0)->orWhere('status',5)->orderBy('afspraak','DESC');
    }


    public function calls(){

        return $this->hasMany(Customer::class)->where('status','!=',0)->orderBy('afspraak');
    }
}
