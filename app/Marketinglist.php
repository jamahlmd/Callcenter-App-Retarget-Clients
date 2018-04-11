<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marketinglist extends Model
{

    protected $fillable = [
        'name'
    ];

    public function customers(){

        return $this->hasMany(Customer::class)->where('status',0)->orderBy('afspraak','DESC');
    }


    public function calls(){

        return $this->hasMany(Customer::class)->where('status','!=',0)->orderBy('afspraak');
    }
}
