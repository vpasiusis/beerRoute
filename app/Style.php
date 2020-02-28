<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    protected $fillable = [
        'cat_id',
        'style_name',
        'last_mod',
     ];
}
