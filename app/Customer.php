<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = [
        'name','e-mail', 'telefoon', 'mobiel','marketinglist_id','opmerking'
    ];


    public function marketinglist(){

        return $this->belongsTo(Marketinglist::class);
    }

    public function retours(){

        return $this->hasMany(Retour::class);
    }
}
