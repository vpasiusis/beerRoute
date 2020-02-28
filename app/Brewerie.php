<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brewerie extends Model
{
    protected $fillable = [
        'name',
        'adress1',
        'city',
        'country',
        'descript',
     ];
}
