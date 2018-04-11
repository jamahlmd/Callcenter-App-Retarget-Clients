<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HubspotContact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'StreetAddress',
        'country',
        'city',
        'bestelGeschiedenis',
        'Orderdatum',
        'Totalproducts'
    ];
}
