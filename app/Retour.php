<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retour extends Model
{
    protected $fillable = [
        'product_naam', 'reden', 'datum', 'customer_id'
    ];

    public function customer(){

        return $this->belongsTo(Customer::class);
    }
}
