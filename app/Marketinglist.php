<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marketinglist extends Model
{

    protected $fillable = [
        'name'
    ];

    public function customers(){

        return $this->hasMany(Customer::class)->orderBy('afspraak');
    }
}
