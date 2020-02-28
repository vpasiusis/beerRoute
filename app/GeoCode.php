<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeoCode extends Model
{
    protected $fillable = [
        'brewery_id',
        'latitude',
        'longitude',
        'accuracy',
     ];
}
