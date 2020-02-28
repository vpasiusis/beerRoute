<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beer extends Model
{
    protected $fillable = [
        'brewery_id',
        'name',
        'cat_id',
        'style_id',
        'descript',
     ];
}
