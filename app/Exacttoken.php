<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exacttoken extends Model
{
    protected $fillable = [
        'refreshtoken','accesstoken','division'
    ];
}
